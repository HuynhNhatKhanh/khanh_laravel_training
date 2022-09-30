<?php
/**
 * FeaturedImages Controller
 *
 * PHP version 8
 *
 * @category  Controllers
 * @package   App
 * @author    Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://localhost/
 */
namespace App\Http\Controllers;

use App\Models\FeaturedImages;
use Illuminate\Http\Request;

/**
 * FeaturedImages Controller
 *
 * @category  Controllers
 * @package   App
 * @author    Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://localhost/
 */
class FeaturedImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return $postNe
     */
    public function read()
    {
        $postNe = FeaturedImages::find(2)
        ->post;
        return $postNe;
    }
}
