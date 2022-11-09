<?php
/**
 * Customer Model
 *
 * PHP version 8
 *
 * @category  Models
 * @package   App
 * @author    Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://localhost/
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product class
 *
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @author Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 */
class Customer extends Model
{
    use HasFactory;

     /**
     * Set Primary key different default.
     *
     * @var array<string>
     */
    protected $primaryKey = 'customer_id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, number>
     */
    protected $fillable = [
        'customer_id',
        'customer_name',
        'email',
        'address',
        'tel_num',
    ];
}
