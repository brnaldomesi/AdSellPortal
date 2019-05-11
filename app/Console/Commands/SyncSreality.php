<?php

namespace App\Console\Commands;

use App\Models\Picture;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use App\Models\Post;
use App\Models\PostValue;
use App\Models\Sync;
use PhpXmlRpc\Value;
use PhpXmlRpc\Request;
use PhpXmlRpc\Client;
use PhpXmlRpc\Encoder;

class SyncSreality extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'sync:sreality';

    /**Å
     * The console command description.
     *
     * @var string
     */
    protected $description = 'synchronize Ads with Sreality Server';

    private $active;
    private $url;
    private $path;
    private $port;
    private $clientId;
    private $password;
    private $key;
    /** @var Client */
    private $client;
    /** @var Encoder */
    private $encoder;

    private $sessionId;

    private $lifeTime = [7 => 1, 14 => 2, 30 => 3, 45 => 4, 90 => 5, 180 => 6, 360 => 7];

    private $customFieldsValues = [];

    private $advert = [];

    private $sellers = [];
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->active = config('sync.sreality.active');
        $this->url = config('sync.sreality.api.url');
        $this->path = config('sync.sreality.api.path');
        $this->port = config('sync.sreality.api.port');
        $this->clientId = config('sync.sreality.api.clientId');
        $this->password = config('sync.sreality.api.password');
        $this->key = config('sync.sreality.api.key');
        $this->client = $this->getClient();
        $this->encoder = new Encoder();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('postId', InputArgument::OPTIONAL, 'if specified then just this Adv will be sync', ''),
        );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if(! $this->active){
            $this->error('Sreality Server is disabled');
            return;
        }
        $this->line('Start synchronize to Sreality');
        /** @var Sync[] $toSync */
        $postId = $this->argument('postId');
        if($postId){
            $toSync = Sync::sreality()->wherePostId($postId)->get();
            if($toSync->isEmpty()){
                $checkPost = Post::find($postId);
                if(! $checkPost){
                    $this->error("Post with Id ($postId) not exist.");
                    die;
                }
                $sync = new Sync();
                $sync->post_id = $checkPost->id;
                $sync->server = 'sreality';
                $sync->add = 1;
                $sync->save();
                $toSync->add($sync);
            }
        }else{
            $toSync = Sync::sreality()->where(function ($query) {
                $query->where('add', 1)
                    ->orWhere('edit', 1)
                    ->orWhere('delete', 1);
            })->get();
        }
        if($toSync->isEmpty()){
            $this->info('nothing to synchronize');
            return;
        }
        $this->line('login to Sreality Server');
        $this->login();

        $this->info('Start synchronize');
        foreach ($toSync as $sync){
            if($sync->delete){
                $this->delete($sync);
            }else{
                $this->addEdit($sync);
            }
        }
        $this->info('End synchronize to Sreality');
        $this->logout();
        return;
    }

    /**
     * @param Sync $sync
     */
    private function addEdit(Sync $sync)
    {
        $seller_rkid = $this->getSellerId();
        $advert_rkid = 'Advert-' . $sync->post->id;

        $this->setPostFieldsValues($sync->post->id);

        $days = !empty($sync->post->latestPayment->package->duration)? $sync->post->latestPayment->package->duration : 0;
        $cat_id = $sync->post->category->parent_id ?: $sync->post->category_id;
        // required for all
        $this->advert = [
            "advert_rkid" => $advert_rkid,
            "advert_function" => $this->getMapValue('advert_function', $sync->post->post_type_id),
            "advert_lifetime" => $this->getLifeTime($days),
            "advert_price" => (float)$sync->post->price,
            "advert_price_currency" => $this->getMapValue('advert_price_currency'),
            "advert_price_unit" => $this->getMapValue('advert_price_unit'),
            "advert_type" => $this->getMapValue('advert_type', $cat_id),
            "advert_subtype" => $this->getMapValue('advert_subtype', $sync->post->category_id),
            "description" => strip_tags($sync->post->description),
            "locality_city" => $sync->post->city->name,
            "locality_inaccuracy_level" => $this->getMapValue('locality_inaccuracy_level'),
            "seller_rkid" => $seller_rkid,
        ];
        // required if
        $this->advert['building_condition'] = $this->getMapValue('building_condition');
        $this->advert['building_type'] = $this->getMapValue('building_type');
        $this->advert['usable_area'] = (float)$this->getMapValue('usable_area');

        $this->advert['garage'] = $this->getMapValue('garage');
        $this->advert['parking_lots'] = $this->getMapValue('parking_lots');
        $this->advert['cellar'] = $this->getMapValue('cellar');
        $this->advert['basin'] = $this->getMapValue('basin');
        $this->advert['balcony'] = $this->getMapValue('balcony');
        $this->advert['loggia'] = $this->getMapValue('loggia');
        $this->advert['terrace'] = $this->getMapValue('terrace');

        $this->advert['estate_area'] = $this->getMapValue('estate_area');

        $this->advert['object_type'] = $this->getMapValue('object_type');

        $this->advert['advert_room_count'] = $this->getMapValue('advert_room_count');

        $this->advert['floor_number'] = (float)$this->getMapValue('floor_number');
        $this->advert['ownership'] = $this->getMapValue('ownership');

        $optional_fields = [
            "advert_price_vat" => $this->getMapValue('advert_price_vat'),
            "advert_price_text_note" => $this->getMapValue('advert_price_text_note'),
            "road_type" => $this->getMapValue('road_type'),
            "water" => $this->getMapValue('water'),
            "gas" => $this->getMapValue('gas'),
            "energy_efficiency_rating" => $this->getMapValue('energy_efficiency_rating'),
            "energy_performance_certificate" => $this->getMapValue('energy_performance_certificate'),
            "telecommunication" => $this->getMapValue('telecommunication'),
            "transport" => $this->getMapValue('transport'),
            "electricity" => $this->getMapValue('electricity'),
            "heating" => $this->getMapValue('heating'),
        ];
        $optional_fields = array_filter($optional_fields);

        foreach ($optional_fields as $key => $val){
            $this->advert[$key] = $val;
        }

        $this->computeSessionId();
        $params = [
            new Value($this->sessionId),
            $this->encoder->encode($this->advert),
        ];
        $request = new Request('addAdvert', $params);
        $response = $this->client->send($request);
        $advert = $this->encoder->decode($response->value());
        if (floor($advert['status'] / 100) != 2) {
            $this->error("Request error add advert [{$advert['status']}]: {$advert['statusMessage']}");
            die;
        }
        $sync->remote_id = $advert_rkid;
        $sync->add = 0;
        $sync->edit = 0;

        /** @var Picture $picture */
        foreach ($sync->post->pictures as $picture){
            if($picture->updated_at->timestamp < $sync->updated_at->timestamp && ! $sync->add)
                continue;
            $this->addPhoto($sync, $picture);
        }

        $sync->save();
    }

    /**
     * @param Sync $sync
     * @param Picture $picture
     */
    private function addPhoto($sync, $picture)
    {
        $url = \Storage::url($picture->filename). getPictureVersion();
        $image_binary = file_get_contents($url);
        $photo_rkid = 'Photo-' . $sync->post->id . '-' . $picture->position;
        $image = [
            'data' => new Value($image_binary, 'base64'),
            'main'  => ($picture->position > 1)? 0 : 1,
            'photo_rkid'  => $photo_rkid,
        ];
        $this->computeSessionId();
        $params = [
            new Value($this->sessionId),
            new Value(0, 'int'),
            $this->encoder->encode($sync->remote_id),
            $this->encoder->encode($image),
        ];
        $request = new Request('addPhoto', $params);
        $response = $this->client->send($request);
        $photo = $this->encoder->decode($response->value());
        if ($photo['status'] != 200) {
            $this->error("Request error add Photo [{$photo['status']}]: {$photo['statusMessage']}");
            die;
        }
    }

    /**
     * @param Sync $sync
     */
    private function topListing(Sync $sync)
    {
        if(! empty($sync->remote_id)){
            $this->computeSessionId();
            $params = [
                new Value($this->sessionId),
                new Value(0, 'int'),
                new Value($sync->remote_id),
            ];
            $request = new Request('topAdvert', $params);
            $response = $this->client->send($request);
            $photo = $this->encoder->decode($response->value());
            if ($photo['status'] != 200) {
                $this->error("Request error add Photo [{$photo['status']}]: {$photo['statusMessage']}");
                die;
            }
        }
    }

    /**
     * @param Sync $sync
     */
    private function delete(Sync $sync)
    {
        if(! empty($sync->remote_id)){
            $this->computeSessionId();
            $params = [
                new Value($this->sessionId),
                new Value(0, 'int'),
                new Value($sync->remote_id),
            ];
            $request = new Request('delAdvert', $params);
            $response = $this->client->send($request);
            $photo = $this->encoder->decode($response->value());
            if ($photo['status'] != 200) {
                $this->error("Request error add Photo [{$photo['status']}]: {$photo['statusMessage']}");
                die;
            }
        }
        $sync->delete();
    }

    private function setSellers()
    {
        if(!empty($this->sellers))
            return;

        $this->computeSessionId();

        $params = [
            new Value($this->sessionId),
        ];
        $request = new Request('listSeller', $params);
        $response = $this->client->send($request);
        $sellers = $this->encoder->decode($response->value());
        if ($sellers['status'] != 200) {
            $this->error("Request error list sellers [{$sellers['status']}]: {$sellers['statusMessage']}");
            die;
        }
        foreach ($sellers['output'] as $seller){
            $this->addToSeller($seller['client_login'], $seller['seller_rkid']);
        }
    }

    private function addToSeller($email, $seller_rkid)
    {
        $this->sellers[$email] = $seller_rkid;
    }

    private function getSellerId()
    {
        $email_name = config('sync.sreality.api.seller_email');
        return ( array_key_exists($email_name, $this->sellers) )? $this->sellers[$email_name] : $this->addSeller();
    }

    private function addSeller()
    {
        $seller = [
            'client_login' => config('sync.sreality.api.seller_email'),
            'client_name'  => config('sync.sreality.api.seller_name'),
            'contact_gsm'  => config('sync.sreality.api.seller_mobile'),
            'contact_email' => config('sync.sreality.api.seller_contact_email'),
        ];
        $this->computeSessionId();
        $seller_rkid = 'Seller-1';
        $params = [
            new Value($this->sessionId),
            new Value(0, 'int'),
            $this->encoder->encode($seller_rkid),
            $this->encoder->encode($seller),
        ];
        $request = new Request('addSeller', $params);
        $response = $this->client->send($request);
        $seller = $this->encoder->decode($response->value());
        if ($seller['status'] != 200) {$this->line(print_r($seller, true));
            $this->error("Request error add seller [{$seller['status']}]: {$seller['statusMessage']}");
            die;
        }
        $this->addToSeller(config('sync.sreality.api.seller_email'), $seller_rkid);
        return $seller_rkid;
    }

    private function login()
    {
        $this->getHash();
        $this->computeSessionId();

        $params = [
            new Value($this->sessionId),
        ];
        $request = new Request('login', $params);
        $response = $this->client->send($request);
        $login = $this->encoder->decode($response->value());
        if ($login['status'] != 200) {
            $this->error("Request error login [{$login['status']}]: {$login['statusMessage']}");
            die;
        }

        $this->info('login successfully');
    }

    private function logout()
    {
        $this->computeSessionId();

        $params = [
            new Value($this->sessionId),
        ];
        $request = new Request('logout', $params);
        $response = $this->client->send($request);
        $login = $this->encoder->decode($response->value());
        if ($login['status'] != 200) {
            $this->error("Request error logout [{$login['status']}]: {$login['statusMessage']}");
            die;
        }

        $this->info('logout successfully');
    }

    private function getHash()
    {
        $params = [
            new Value($this->clientId, 'int'),
        ];
        $request = new Request('getHash', $params);
        $response = $this->client->send($request);
        $getHash = $this->encoder->decode($response->value());
        if ($getHash['status'] != 200) {
            $this->error("Request error getHash [{$getHash['status']}]: {$getHash['statusMessage']}");
            die;
        }
        $this->sessionId = $getHash['output'][0]['sessionId'];
    }
    /**
     * @return Client
     */
    private function getClient()
    {
        if(empty($this->path) && empty($this->port)){
            return new Client($this->url);
        }else{
            return new Client($this->path, $this->url, $this->port);
        }
    }
    /**
     * set new sessionId
     *
     * @param string $sessionId current sessionId
     * @param string $password md5 hash password
     * @param string $key import key
     */
    private function computeSessionId()
    {
        $newVarPart = md5($this->sessionId . $this->password . $this->key);
        $this->sessionId = substr($this->sessionId, 0, 48) . $newVarPart;
    }

    /// Helper functions ///
    private function getMapValue($configKey, $value = null)
    {
        $field_mapping = config("sync.mapping.$configKey");
        $sreality_mapping = config("sync.sreality.mapping.$configKey");
        $required = ! empty($sreality_mapping['options']['required']) || $this->checkRequiredIf($sreality_mapping);
        $default = isset($sreality_mapping['options']['default'])? $sreality_mapping['options']['default'] : null;

        if($value) {
            if (!array_key_exists($value, $field_mapping)) {
                $this->error("add the correct IDs to the '$configKey' array in the sync mapping config file");
                die;
            }
            $key = $field_mapping[$value];
            if (!array_key_exists($key, $sreality_mapping['map'])) {
                $this->error("add the '$key' key to the '$configKey' map array in the sync Sreality mapping config file");
                die;
            }
            $value = $sreality_mapping['map'][$key];
        }else{
            $available_ids = array_keys($field_mapping);
            $customFieldsValues = array_keys($this->customFieldsValues);
            $ids = array_intersect($available_ids, $customFieldsValues);
            $ids = array_values($ids);
            if(empty($ids)){
                if($required && is_null($default)) {
                    $this->error("add the correct IDs to the '$configKey' array in the sync mapping config file");
                    die;
                }else{
                    return $default;
                }
            }
            $value = (! empty($sreality_mapping['options']['multi']))? [] : null;
            if(! empty($sreality_mapping['options']['text'])){
                $value = $this->customFieldsValues[$ids[0]];
                $ids = [];
            }
            foreach ($ids as $id){
                $key = $field_mapping[$id];
                if (!array_key_exists($key, $sreality_mapping['map'])) {
                    $this->error("add the '$key' key to the '$configKey' map array in the sync Sreality mapping config file");
                    die;
                }
                if(! empty($sreality_mapping['options']['multi'])){
                    $value[] = $sreality_mapping['map'][$key];
                }else{
                    $value = $sreality_mapping['map'][$key];
                    break;
                }
            }
        }
        return $value;
    }

    private function checkRequiredIf($mapping)
    {
        if(empty($mapping['options']['required_if']) || ! is_array($mapping['options']['required_if']))
            return false;

        foreach ($mapping['options']['required_if'] as $key => $arr){
            if(! array_key_exists($key, $this->advert))
                return false;

            if(! in_array($this->advert[$key], $arr))
                return false;
        }
        return true;
    }
    private function setPostFieldsValues($postId)
    {
        $fieldTypesHavingOptions = ['checkbox_multiple', 'radio', 'select'];
        /** @var PostValue[] $customFieldsValues */
        $customFieldsValues = PostValue::where('post_id', $postId)->get();
        if (empty($customFieldsValues) || $customFieldsValues->count() <= 0) {
            $this->customFieldsValues = [];
            return;
        }

        foreach ($customFieldsValues as $fieldsValue) {
            if (in_array($fieldsValue->field->type, $fieldTypesHavingOptions)) {
                $this->customFieldsValues[$fieldsValue->option_id ?: $fieldsValue->value] = '';
            } else {
                $this->customFieldsValues[$fieldsValue->field_id] = $fieldsValue->value;
            }
        }
    }

    private function getLifeTime($days)
    {
        $temp = null;
        $lifetimes = array_keys($this->lifeTime);
        foreach ($lifetimes as $lifetime){
            if($lifetime > $days)
                break;
            $temp = $lifetime;
        }
        $temp = $temp ?: 30;
        return $this->lifeTime[$temp];
    }
}
