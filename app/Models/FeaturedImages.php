<?php
/**
 * FeaturedImages Model
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
 * FeaturedImages Model
 *
 * @category  Models
 * @package   App
 * @author    Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://localhost/
 */
class FeaturedImages extends Model
{
    use HasFactory;

    protected $table = 'featured_images';
    protected $fillable = ['file', 'post_id'];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
