<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


class postController extends Controller
{
    //this function for Question 1
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

    //this function for Question 2
    public function filter(Request $request){
        //filter BY
        // 1-postId (display all comments for specific post id ) && (name =null, email=null , body =null)
        //2-name  (display all comments for specific name ) && (postId =null, email=null , body =null)
        //3-email (display all comments for specific email ) && (postId =null, name=null , body =null)
        //4-body (display all comments which have word or words indise body "search inside body " (postId =null, email=null , body =null)

        $allComments = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'),true);
        $result = array();
        if(isset($request->postId) && !is_null($request->postId) && !isset($request->name)
            && !isset($request->email) && !isset($request->body) ){
            foreach ($allComments as $comment) {
                if($comment['postId'] == $request->postId){
                    $result[] = $comment;
                }
            }
            return response()->json($result,200);

        }elseif (isset($request->name) && !is_null($request->name) && !isset($request->postId)
            && !isset($request->email) && !isset($request->body) ){
            foreach ($allComments as $comment) {
                if ($comment['name'] == $request->name) {
                    $result[] = $comment;
                }
            }
            return response()->json($result,200);
        }elseif (isset($request->email) && !is_null($request->email) && !isset($request->postId)
            && !isset($request->name) && !isset($request->body) ){
            foreach ($allComments as $comment) {
                if ($comment['email'] == $request->email) {
                    $result[] = $comment;
                }
            }
            return response()->json($result,200);
        }elseif (isset($request->body) && !is_null($request->body) && !isset($request->postId)
            && !isset($request->name) && !isset($request->email) ){
            foreach ($allComments as $comment) {
                if(strpos($comment['body'], $request->body) !== false){
                    $result[] = $comment;
                }
            }
            return response()->json($result,200);
        }
        //next setp check both Variables
        //1- postId and name (email =null && body =null)
        //2- postId and email (name =null && body =null)
        //3- postId and body (name =null && email =null)
        //4- name and email (postId = null && body =null)
        //5- ETC ...

        //next setp check 3  Variables togathers
        //1- postId and name and email ( body =null)
        //2- postId and email and body  (name =null)
        //3- etc

        //next setp check 4  Variables togathers
        //1- postId and name and email and body



    }


}
