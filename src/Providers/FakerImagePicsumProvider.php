<?php

namespace Petrelli\LiveStatics\Providers;


use Faker\Provider\Base as BaseProvider;


class FakerImagePicsumProvider extends BaseProvider
{

    protected static $baseUrl = "http://picsum.photos/";


    protected static $picsumPhotosMaxImageID = 1084;

    protected static $picsumPhotosInvalidImageIDs = [
        86=>82, 97=>39, 105=>96, 138=>103, 148=>16, 150=>23, 205=>116, 207=>173, 224=>37, 226=>52,
        245=>127, 246=>165, 262=>36, 285=>169, 286=>47, 298=>146, 303=>273, 332=>82, 333=>127, 346=>200,
        359=>42, 394=>356, 414=>269, 422=>131, 438=>254, 462=>114, 463=>419, 470=>198, 489=>104, 540=>249,
        561=>549, 578=>571, 587=>212, 589=>424, 592=>528, 595=>249, 597=>495, 601=>80, 624=>404, 632=>317,
        636=>533, 644=>556, 647=>237, 673=>447, 697=>614, 706=>271, 707=>529, 708=>53, 709=>372, 710=>323,
        711=>18, 712=>403, 713=>425, 714=>488, 720=>30, 725=>264, 734=>81, 745=>251, 746=>437, 747=>158,
        748=>113, 749=>175, 750=>111, 751=>291, 752=>388, 753=>424, 754=>28, 759=>289, 761=>247, 762=>161,
        763=>99, 771=>31, 792=>340, 801=>617, 812=>672, 843=>385, 850=>234, 854=>130, 895=>562, 897=>75,
        899=>594, 917=>445, 920=>501, 934=>485, 956=>886, 963=>371, 968=>913, 1007=>30, 1017=>683,
        1030=>649, 1034=>538, 1046=>47
    ];

    protected static function validPicsumPhotosImageID($id=null)
    {
        if ( is_null($id) ) {
            $id = static::numberBetween(0, static::$picsumPhotosMaxImageID);
        }
        if ( array_key_exists($id, static::$picsumPhotosInvalidImageIDs) ) {
            return static::$picsumPhotosInvalidImageIDs[$id];
        }
        return $id;
    }

    public static function imageUrl($width = 640, $height = 480, $random = null)
    {
        $url = "{$width}/{$height}";
        $args = [];

        if ( !$random ) {
            $args["image"] = static::validPicsumPhotosImageID(rand(1, self::$picsumPhotosMaxImageID));
        } else {
            $args["image"] = static::validPicsumPhotosImageID($random);
        }

        if ( count($args) > 0 ) {
            $url .= "?" . http_build_query($args);
        }

        return static::$baseUrl . $url;
    }


}
