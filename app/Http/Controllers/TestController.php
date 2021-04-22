<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function testApi() {
        $posts = json_decode(file_get_contents('https://moskvichmag.ru/wp-json/wp/v2/posts/'));

        foreach ($posts as $post){
            $post->content->rendered = str_replace('<p>','<Text style={paragraph}>', $post->content->rendered);
            $post->content->rendered = str_replace('</p>','</Text>', $post->content->rendered);
            $post->content->rendered = str_replace('<strong>','<Text style={strong}>', $post->content->rendered);
            $post->content->rendered = str_replace('</strong>','</Text>', $post->content->rendered);
            $post->content->rendered = strip_tags($post->content->rendered, '<Text><img>');
        }
        return response()->json($posts);
    }

    public function testApiMain () {
        return response()->json(['url' => 'https://moskvichmag.ru/']);
    }
}
