<?php
include "rack.inc";
include "subracks.inc";
    //this is the basic way of getting a database handler from PDO, PHP's built in quasi-ORM
    $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
    if (!$dbhandle) die ($error);
 
    //this is a sample query which gets some data, the order by part shuffles the results
    //the limit 0, 10 takes the first 10 results.
    // you might want to consider taking more results, implementing "pagination", 
    // ordering by rank, etc.
    $query = "SELECT rack, words FROM racks WHERE length=7 and weight <= 10 order by random() limit 0, 10";
    
    //this next line could actually be used to provide user_given input to the query to 
    //avoid SQL injection attacks
    $statement = $dbhandle->prepare($query);
    $statement->execute();
    
    //The results of the query are typically many rows of data
    //there are several ways of getting the data out, iterating row by row,
    //I chose to get associative arrays inside of a big array
    //this will naturally create a pleasant array of JSON data when I echo in a couple lines
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    $myrack = generate_rack(7); //Alp
    $subracks = get_subracks($myrack);
    
    foreach($subracks as $srack)
    {
        $query = "SELECT rack,words FROM racks WHERE rack = '$srack'";
        // This is not an optimal way to do this but anyways. I will go with this for now!
        $statement = $dbhandle->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if($results)
        {
            foreach($results as $rackpair)
            {
                //print_r($rackpair);
                $tempObj = new stdClass();
                //$tempObj->racks = $rackpair['rack'];
                $tempObj->words = explode('@@', $rackpair['words']);
                //print_r($tempObj->words);
                foreach($tempObj->words as $word)
                {
                    $finalWords[] = $word;
                }
            }
        }
    }
    
    $myObj = new stdClass();
    $myObj->rack = $myrack;
    $myObj->subRacks = $finalWords;
    
    
    //this part is perhaps overkill but I wanted to set the HTTP headers and status code
    //making to this line means everything was great with this request
    header('HTTP/1.1 200 OK');
    //this lets the browser know to expect json
    header('Content-Type: application/json');
    //this creates json and gives it 
    echo json_encode($myObj);
?>
