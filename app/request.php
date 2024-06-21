<?php

function getAllUser()
{
    return fetchAssoc(queryData('SELECT * FROM user'));
}
function getUser($id)
{
    return fetchAssoc(queryData("SELECT * FROM user WHERE id = $id"));
}
