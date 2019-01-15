<?php
/**
 * LaraClassified - Geo Classified Ads Software
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Helpers;


class DBTool
{
	/**
	 * Get PDO Connexion
	 *
	 * @param array $database
	 * @return \PDO
	 */
	public static function getPDOConnexion($database = [])
	{
		$error = null;
		
		// Retrieve Database Parameters from the /.env file,
		// If they are not set during the function call.
		if (empty($database)) {
			$database = DBTool::getDatabaseConnectionInfo();
		}
		
		// Database Parameters
		$driver = isset($database['driver']) ? $database['driver'] : 'mysql';
		$host = isset($database['host']) ? $database['host'] : '';
		$port = isset($database['port']) ? $database['port'] : '';
		$username = isset($database['username']) ? $database['username'] : '';
		$password = isset($database['password']) ? $database['password'] : '';
		$database = isset($database['database']) ? $database['database'] : '';
		$charset = isset($database['charset']) ? $database['charset'] : 'utf8';
		$socket = isset($database['socket']) ? $database['socket'] : '';
		$options = isset($database['options']) ? $database['options'] : [
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_EMULATE_PREPARES   => true,
			\PDO::ATTR_CURSOR             => \PDO::CURSOR_FWDONLY,
		];
		
		try {
			// Get the Connexion's DSN
			if (empty($socket)) {
				$dsn = $driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $database . ';charset=' . $charset;
			} else {
				$dsn = $driver . ':unix_socket=' . $database['socket'] . ';dbname=' . $database . ';charset=' . $charset;
			}
			// Connect to the Database Server
			$pdo = new \PDO($dsn, $username, $password, $options);
			
			return $pdo;
			
		} catch (\PDOException $e) {
			$error = "<pre><strong>ERROR:</strong> Can't connect to the database server. " . $e->getMessage() . "</pre>";
		} catch (\Exception $e) {
			$error = "<pre><strong>ERROR:</strong> The database connection failed. " . $e->getMessage() . "</pre>";
		}
		
		die($error);
	}
	
	/**
	 * Database Connection Info
	 *
	 * @return mixed
	 */
	public static function getDatabaseConnectionInfo()
	{
		$config = DBTool::getLaravelDatabaseConfig();
		$defaultDatabase = $config['connections'][$config['default']];
		
		// Database Parameters
		$database['driver'] = $defaultDatabase['driver'];
		$database['host'] = $defaultDatabase['host'];
		$database['port'] = (int)$defaultDatabase['port'];
		$database['socket'] = $defaultDatabase['unix_socket'];
		$database['username'] = $defaultDatabase['username'];
		$database['password'] = $defaultDatabase['password'];
		$database['database'] = $defaultDatabase['database'];
		$database['charset'] = $defaultDatabase['charset'];
		$database['options'] = [
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_EMULATE_PREPARES   => true,
			\PDO::ATTR_CURSOR             => \PDO::CURSOR_FWDONLY,
		];
		
		return $database;
	}
	
	/**
	 * @return array
	 */
	public static function getLaravelDatabaseConfig()
	{
		return (array)include realpath(__DIR__ . '/../../config/database.php');
	}
	
	/**
	 * Get full table name by adding the DB prefix
	 *
	 * @param $name
	 * @return string
	 */
	public static function rawTable($name)
	{
		$config = DBTool::getLaravelDatabaseConfig();
		$defaultDatabase = $config['connections'][$config['default']];
		$databasePrefix = $defaultDatabase['prefix'];
		
		return $databasePrefix . $name;
	}
	
	/**
	 * Close PDO Connexion
	 *
	 * @param $pdo
	 */
	public static function closePDOConnexion(&$pdo)
	{
		$pdo = null;
	}
	
	/**
	 * Get full table name by adding the DB prefix
	 *
	 * @param $name
	 * @return string
	 */
	public static function table($name)
	{
		return \DB::getTablePrefix() . $name;
	}
	
	/**
	 * Quote a value with astrophe to inject to an SQL statement
	 *
	 * @param $value
	 * @return mixed
	 */
	public static function quote($value)
	{
		return \DB::getPdo()->quote($value);
	}
	
	/**
	 * Import SQL File
	 *
	 * @param $pdo
	 * @param $sqlFile
	 * @param null $tablePrefix
	 * @param null $InFilePath
	 * @return bool
	 */
	public static function importSqlFile($pdo, $sqlFile, $tablePrefix = null, $InFilePath = null)
	{
		try {
			
			if (!$pdo instanceof \PDO) {
				return false;
			}
			
			// Enable LOAD LOCAL INFILE
			$pdo->setAttribute(\PDO::MYSQL_ATTR_LOCAL_INFILE, true);
			
			$errorDetect = false;
			
			// Temporary variable, used to store current query
			$tmpLine = '';
			
			// Read in entire file
			$lines = file($sqlFile);
			
			// Loop through each line
			foreach ($lines as $line) {
				// Skip it if it's a comment
				if (substr($line, 0, 2) == '--' || trim($line) == '') {
					continue;
				}
				
				// Read & replace prefix
				$line = str_replace(['<<prefix>>', '<<InFilePath>>'], [$tablePrefix, $InFilePath], $line);
				
				// Add this line to the current segment
				$tmpLine .= $line;
				
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';') {
					try {
						// Perform the Query
						$pdo->exec($tmpLine);
					} catch (\PDOException $e) {
						echo "<br><pre>Error performing Query: '<strong>" . $tmpLine . "</strong>': " . $e->getMessage() . "</pre>\n";
						$errorDetect = true;
					}
					
					// Reset temp variable to empty
					$tmpLine = '';
				}
			}
			
			// Check if error is detected
			if ($errorDetect) {
				return false;
			}
			
		} catch (\Exception $e) {
			echo "<br><pre>Exception => " . $e->getMessage() . "</pre>\n";
			return false;
		}
		
		return true;
	}
	
	/**
	 * Perform MySQL Database Backup
	 *
	 * @param $pdo
	 * @param string $tables
	 * @param string $filePath
	 * @return bool
	 */
	public static function backupDatabaseTables($pdo, $tables = '*', $filePath = '/')
	{
		try {
			
			if (!$pdo instanceof \PDO) {
				return false;
			}
			
			// Get all of the tables
			if ($tables == '*') {
				$tables = [];
				$query = $pdo->query('SHOW TABLES');
				while ($row = $query->fetch_row()) {
					$tables[] = $row[0];
				}
			} else {
				$tables = is_array($tables) ? $tables : explode(',', $tables);
			}
			
			if (empty($tables)) {
				return false;
			}
			
			$out = '';
			
			// Loop through the tables
			foreach ($tables as $table) {
				$query = $pdo->query('SELECT * FROM ' . $table);
				$numColumns = $query->field_count;
				
				// Add DROP TABLE statement
				$out .= 'DROP TABLE ' . $table . ';' . "\n\n";
				
				// Add CREATE TABLE statement
				$query2 = $pdo->query('SHOW CREATE TABLE ' . $table);
				$row2 = $query2->fetch_row();
				$out .= $row2[1] . ';' . "\n\n";
				
				// Add INSERT INTO statements
				for ($i = 0; $i < $numColumns; $i++) {
					while ($row = $query->fetch_row()) {
						$out .= "INSERT INTO $table VALUES(";
						for ($j = 0; $j < $numColumns; $j++) {
							$row[$j] = addslashes($row[$j]);
							$row[$j] = preg_replace("/\n/us", "\\n", $row[$j]);
							if (isset($row[$j])) {
								$out .= '"' . $row[$j] . '"';
							} else {
								$out .= '""';
							}
							if ($j < ($numColumns - 1)) {
								$out .= ',';
							}
						}
						$out .= ');' . "\n";
					}
				}
				$out .= "\n\n\n";
			}
			
			// Save file
			\File::put($filePath, $out);
			
		} catch (\Exception $e) {
			echo "<br><pre>Exception => " . $e->getMessage() . "</pre>\n";
			return false;
		}
		
		return true;
	}
	
	/**
	 * Check If a MySQL function exists
	 *
	 * @param $name
	 * @return bool
	 */
	public static function checkIfMySQLFunctionExists($name)
	{
		if (!config('settings.listing.cities_extended_searches') || request()->ajax()) {
			return false;
		}
		
		$cacheId = 'checkIfMySQLFunctionExists.' . $name;
		$exists = \Cache::rememberForever($cacheId, function () use ($name) {
			// Get the app's database name
			$schema = config('database.connections.' . config('database.default', 'mysql') . '.database');
			
			// Check with method #1
			try {
				$sql = 'SHOW FUNCTION STATUS;';
				$entries = \DB::select(\DB::raw($sql));
				$entries = collect($entries)->whereStrict('Db', $schema)->whereStrict('Name', $name);
				$exists = !$entries->isEmpty();
			} catch (\Exception $e) {
				$exists = false;
			}
			
			// Check with method #2
			if (!$exists) {
				try {
					$sql = 'SELECT ROUTINE_NAME FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_TYPE="FUNCTION" AND ROUTINE_SCHEMA="' . $schema . '"';
					$entries = \DB::select(\DB::raw($sql));
					$entries = collect($entries)->whereStrict('ROUTINE_NAME', $name);
					$exists = !$entries->isEmpty();
				} catch (\Exception $e) {
					$exists = false;
				}
			}
			
			return $exists;
		});
		
		return $exists;
	}
	
	/**
	 * Create the MySQL Distance Calculation function, If doesn't exist,
	 * Using the Haversine or the Orthodromy formula
	 *
	 * @param $name
	 * @return bool
	 */
	public static function createMySQLDistanceCalculationFunction($name)
	{
		if (!config('settings.listing.cities_extended_searches') || request()->ajax()) {
			return false;
		}
		
		if ($name == 'orthodromy') {
			return DBTool::createMySQLOrthodromyFunction();
		}
		
		if ($name == 'haversine') {
			return DBTool::createMySQLHaversineFunction();
		}
		
		return false;
	}
	
	/**
	 * Create the MySQL Orthodromy function
	 *
	 * DEFINITION
	 * An orthodromic or great-circle route on the Earth's surface is the shortest possible real way between any two points.
	 *
	 * FORMULA
	 * Ortho(A, B) = r x acos[[cos(LatA) x cos(LatB) x cos(LongB-LongA)] + [sin(LatA) x sin(LatB)]]
	 *
	 * WHERE
	 * 1) r is the radius of the Earth (6371 kilometers, 3959 miles)
	 *
	 * NOTE
	 * The Geonames lat & lon data are in Decimal Degrees (wgs84)
	 * Decimal Degrees to Radians = RADIANS(DecimalDegrees) or DecimalDegrees * Pi/180
	 *
	 * SOURCES
	 * https://fr.wikipedia.org/wiki/Orthodromie
	 * http://www.lion1906.com/Pages/english/orthodromy_and_co.html
	 *
	 * USAGE
	 * orthodromy(lat1, lon1, lat2, lon2) as distance
	 *
	 * @return bool
	 */
	public static function createMySQLOrthodromyFunction()
	{
		try {
			
			// Drop the function, If exists
			$sql = 'DROP FUNCTION IF EXISTS orthodromy;';
			\DB::statement($sql);
			
			// Create the function
			// Remove " DELIMITER $$ " (also $$ DELIMITER ; at the end)
			// I think DELIMITER is no longer required with PHP PDO
			$sql = 'CREATE FUNCTION orthodromy (
		lat1 FLOAT, lon1 FLOAT,
		lat2 FLOAT, lon2 FLOAT
	) RETURNS FLOAT
	NO SQL DETERMINISTIC
	COMMENT "Returns the distance in degrees on the Earth between two known points of latitude and longitude. To get km, multiply by 6371, and miles by 3959"
BEGIN
	DECLARE r FLOAT unsigned DEFAULT 6371;
	DECLARE lonDiff FLOAT unsigned;
	DECLARE a FLOAT unsigned;
	DECLARE c FLOAT unsigned;
 
	SET lonDiff = RADIANS(lon2 - lon1);
	SET lat1 = RADIANS(lat1);
	SET lat2 = RADIANS(lat2);
	
	SET c = ACOS((COS(lat1) * COS(lat2) * COS(lonDiff)) + (SIN(lat1) * SIN(lat2)));
 
	RETURN (r * c);
END;';
			
			\DB::statement($sql);
			
			return true;
			
		} catch (\Exception $e) {
			return false;
		}
	}
	
	/**
	 * Create the MySQL Haversine function
	 *
	 * @todo: I don't recommend it for now.
	 *
	 * DEFINITION
	 * The haversine formula is an equation important in navigation,
	 * giving great-circle distances between two points on a sphere from their longitudes and latitudes.
	 *
	 * FORMULA
	 * distance = r * 2 * ASIN(SQRT(a))
	 *
	 * WHERE
	 * 1) r is the radius of the Earth (6371 kilometers, 3959 miles)
	 * 2) a = POW(SIN(latDiff / 2), 2) + COS(lat1) * COS(lat2) * POW(SIN(LonDiff / 2), 2)
	 * 3) All the latitude & longitude values are already in radians
	 *
	 * NOTE
	 * The Geonames lat & lon data are in Decimal Degrees (wgs84)
	 * Decimal Degrees to Radians = RADIANS(DecimalDegrees) or DecimalDegrees * Pi/180
	 *
	 * SOURCES
	 * https://en.wikipedia.org/wiki/Haversine_formula
	 * https://rosettacode.org/wiki/Haversine_formula
	 *
	 * USAGE
	 * haversine(lat1, lon1, lat2, lon2) as distance
	 *
	 * @return bool
	 */
	public static function createMySQLHaversineFunction()
	{
		try {
			
			// Drop the function, If exists
			$sql = 'DROP FUNCTION IF EXISTS haversine;';
			\DB::statement($sql);
			
			// Create the function
			// Remove " DELIMITER $$ " (also $$ DELIMITER ; at the end)
			// I think DELIMITER is no longer required with PHP PDO
			$sql = 'CREATE FUNCTION haversine (
		lat1 FLOAT, lon1 FLOAT,
		lat2 FLOAT, lon2 FLOAT
	) RETURNS FLOAT
	NO SQL DETERMINISTIC
	COMMENT "Returns the distance in degrees on the Earth between two known points of latitude and longitude. To get km, multiply by 6371, and miles by 3959"
BEGIN
	DECLARE r FLOAT unsigned DEFAULT 6371;
	DECLARE latDiff FLOAT unsigned;
	DECLARE lonDiff FLOAT unsigned;
	DECLARE a FLOAT unsigned;
	DECLARE c FLOAT unsigned;
 
	SET latDiff = RADIANS(lat2 - lat1);
	SET lonDiff = RADIANS(lon2 - lon1);
	SET lat1 = RADIANS(lat1);
	SET lat2 = RADIANS(lat2);
 
	SET a = POW(SIN(latDiff / 2), 2) + COS(lat1) * COS(lat2) * POW(SIN(lonDiff / 2), 2);
	SET c = 2 * ASIN(SQRT(a));
 
	RETURN (r * c);
END;';
			
			\DB::statement($sql);
			
			return true;
			
		} catch (\Exception $e) {
			return false;
		}
	}
}
