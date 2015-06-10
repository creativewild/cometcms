<?php
namespace App\Repositories;

use App\Opponent;
use App\Repositories\Contracts\OpponentsRepositoryInterface;
use App\Libraries\GridView\GridViewInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OpponentsRepository extends AbstractRepository implements OpponentsRepositoryInterface, GridViewInterface {

    private $uploadPath;

    public function __construct(Opponent $opponent)
    {
        parent::__construct($opponent);

        $this->uploadPath = base_path() . '/public/uploads/opponents/';
    }

    public function insertFile($opponentID, UploadedFile $file)
    {
        $imageName = $opponentID . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($this->uploadPath, $imageName);
            $this->update($opponentID, ['image' => $imageName]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getByPageGrid($page, $limit, $sortColumn, $order, $searchTerm = null)
    {
        $sortColumn !== null ?: $sortColumn = 'name'; // Default order by column
        $order !== null ?: $order = 'asc'; // Default sorting

        $model = $this->model->orderBy($sortColumn, $order);

        if ($searchTerm)
            $model->where('name', 'LIKE', '%' . $searchTerm . '%');

        $result['count'] = $model->count();
        $result['items'] = $model->skip($limit * ($page - 1))->take($limit)->get();

        return $result;
    }

} 