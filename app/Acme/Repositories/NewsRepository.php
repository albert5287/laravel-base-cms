<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 15:31
 */

namespace Acme\Repositories;




use App\News;

class NewsRepository extends DbRepository
{
    function __construct(News $model){
        $this->model = $model;
    }

    /**
     * function to insert or update a new news
     * @param News $new
     * @param $data
     */
    public function insertUpdateNew(News $new, $data)
    {
        $this->insertUpdateMultiLanguage($new, $data);
        $relatedMedia = isset($data['_relatedMedia']) ? $data['_relatedMedia'] : [];
        $new->syncMedia($relatedMedia);


    }
}