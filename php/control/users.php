<?php
class Users
{
    public function coutUsers()
    {
        $sql = "select count(user_id) as num from orders";
        $mydb = new DB_connect();
        $results = $mydb->query($sql);
        return $results;
    }
}