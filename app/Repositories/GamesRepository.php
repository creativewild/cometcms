<?php
namespace App\Repositories;

use App\Game, App\Map;
use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\GamesRepositoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Libraries\ImageUploadTrait as ImageUpload;

class GamesRepository extends AbstractRepository implements GamesRepositoryInterface, GridViewInterface {

    use ImageUpload;

    public function __construct(Game $game)
    {
        parent::__construct($game);

        $this->setUploadPath(base_path() . '/public/uploads/games/');
    }

    public function allWithMaps()
    {
        return $this->model->with('maps')->get();
    }

    public function delete($gameID)
    {
        // TODO: Delete maps images
        $this->deleteImage($gameID);
        $this->model->find($gameID)->maps()->delete();
        return parent::delete($gameID);
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $model = $this->model->orderBy($sortColumn, $order);

        if($searchTerm)
            $model->where('name', 'LIKE', '%'. $searchTerm .'%')->orWhere('code', 'LIKE', '%'. $searchTerm .'%');

        $result['count'] = $model->count();
        $result['items'] = $model->with('maps')->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

} 