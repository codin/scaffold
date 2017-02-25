<?php 

namespace App\Models;

use App\Models\Model;
use Scaffold\Auth\Authable;
use Scaffold\Auth\AuthableTrait;
 
/**
 * Represent the users of our application
 */
class UserModel extends Model implements Authable
{
    use AuthableTrait;

    /**
     * The table where these records
     * are stored in the db.
     * 
     * @var string
     */
    protected $table = 'users';
}