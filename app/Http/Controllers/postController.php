<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class postController extends Controller
{
    public function TopPosts(){

        $allPosts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'),true);
        $allComments = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'),true);
        $postsData =array();

         foreach ($allPosts as $post){
             $postsData[] =  array(
                 'post_id'=>  $post['id'] ,
                 'post_title'=> $post['title'],
                 'post_body'=> $post['body'],
                 'total_number_of_comments' =>array_count_values(array_column($allComments, 'postId'))[$post['id']],
             );

         }

        //sort the result
        $flag = true;
        while ( $flag )
        {
            $flag = false;
            for( $j=0;  $j < count($postsData)-1; $j++)
            {
                if ( $postsData[$j]["total_number_of_comments"] < $postsData[$j+1]["total_number_of_comments"] )
                {
                    $temp = $postsData[$j];
                    //swap the two between each other
                    $postsData[$j] = $postsData[$j+1];
                    $postsData[$j+1]=$temp;
                    $flag = true; //show that a swap occurred
                }
            }
        }
        return response()->json($postsData,200) ;
    }

}
