<?php
/**
 * LaraClassified - Geo Classified Ads CMS
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

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Post\Traits\CustomFieldTrait;
use App\Models\Category;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends FrontController
{
	use CustomFieldTrait;
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getSubCategories(Request $request)
	{
		$languageCode = $request->input('languageCode');
		$parentId = $request->input('catId');
		$selectedSubCatId = $request->input('selectedSubCatId');
		
		// Get SubCategories by Parent Category ID
		$cacheId = 'subCategories.parentId.' . $parentId . '.' . $languageCode;
		$subCats = Cache::remember($cacheId, $this->cacheExpiration, function () use ($languageCode, $parentId) {
			$subCats = Category::transIn($languageCode)->where('parent_id', $parentId)->orderBy('lft')->get();
			
			return $subCats;
		});
		
		// Select the Parent Category if his haven't any SubCategories
		if ($subCats->count() <= 0) {
			$cacheId = 'subCategories.translationOf.' . $parentId . '.' . $languageCode;
			$subCats = Cache::remember($cacheId, $this->cacheExpiration, function () use ($languageCode, $parentId) {
				$subCats = Category::transIn($languageCode)->where('translation_of', $parentId)->orderBy('lft')->get();
				
				return $subCats;
			});
		}
		
		// If SubCategories are not found, Get all the Parent Categories
		if ($subCats->count() <= 0) {
			$cacheId = 'subCategories.parentId.0.' . $languageCode;
			$subCats = Cache::remember($cacheId, $this->cacheExpiration, function () use ($languageCode, $parentId) {
				$subCats = Category::transIn($languageCode)->where('parent_id', 0)->orderBy('lft')->get();
				
				return $subCats;
			});
		}
		
		// If SubCategories are still not found, Show an error message
		if ($subCats->count() <= 0) {
			return response()->json(['error' => ['message' => t("Error. Please select another category.")], 404]);
		}
		
		// Get Result's Data
		$data = [
			'subCats'          => $subCats,
			'countSubCats'     => $subCats->count(),
			'selectedSubCatId' => $selectedSubCatId,
		];
		
		return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
	}
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCustomFields(Request $request)
	{
		$languageCode = $request->input('languageCode');
		$parentCatId = $request->input('catId');
		$catId = $request->input('subCatId');
		$postId = $request->input('postId');
		
		// Custom Fields vars
		$errors = stripslashes($request->input('errors'));
		$errors = collect(json_decode($errors, true));
		$oldInput = stripslashes($request->input('oldInput'));
		$oldInput = json_decode($oldInput, true);
		
		// Get Category nested IDs
		$catNestedIds = (object)[
			'parentId' => $parentCatId,
			'id'       => $catId,
		];
		
		// Get the Category's Custom Fields buffer
		$customFields = $this->getCategoryFieldsBuffer($catNestedIds, $languageCode, $errors, $oldInput, $postId);
		
		// Get Result's Data
		$data = [
			'customFields' => $customFields,
		];
		
		return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
	}
}
