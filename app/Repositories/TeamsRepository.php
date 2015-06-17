<?php
namespace App\Repositories;

use App\Libraries\GridView\GridViewInterface;
use App\Repositories\Contracts\TeamsRepositoryInterface;
use App\Team;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TeamsRepository extends AbstractRepository implements TeamsRepositoryInterface {

    private $uploadPath;
    /**
     * Initiate the repository with team model
     * 
     * @param Team $team Model
     */
    public function __construct(Team $team)
    {
        parent::__construct($team);

        $this->uploadPath = base_path() . '/public/uploads/squads/';
    }

    /**
     * Add members to specefied team
     * 
     * @param  array $data    Array with member data
     * @param  int   $teamID  ID of the team we are adding members to
     * @return void           Void since we use transaction in insert() method
     */
    public function insertMembers($data, $teamID)
    {
        // We go through each element since we need to get rid of garbage properties from client JSON
        foreach ($data as $member) {
            \DB::table('team_roster')->insert([
                'user_id' => $member['user_id'],
                'team_id' => $teamID,
                'position' => isset($member['position']) ?: null,
                'status' => isset($member['status']) ?: null,
                'captain' => isset($member['captain']) ?: 0
            ]);
        }
    }

    /**
     * Add new team and team members. Uses transactions, if transaction commits returns true.
     * 
     * @param  array $data Array of data
     * @return bool        Was transaction commited
     */
    public function insert($data)
    {
        try {
            \DB::beginTransaction();
            $teamModel = parent::insert($data);

            if ($teamModel) {
                $this->insertMembers($data['members'], $teamModel->id);
            }
        }
        catch (\Exception $e) {
            \DB::rollback();

            return false;
        }
        \DB::commit();

        return true;
    }

    public function updateImage(UploadedFile $file, $teamID)
    {
        $imageName = $teamID . '.' . $file->getClientOriginalExtension();

        try {
            $file->move($this->uploadPath, $imageName);
            $this->update($teamID, ['image' => $imageName]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get members of a specific team
     *
     * @param $teamID
     * @return mixed
     */
    public function getTeamData($teamID)
    {
        return $this->model->where('id', '=', $teamID)->with('roster')->first();
    }

    public function getTeamRoster($teamID)
    {

    }
}