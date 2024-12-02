<?php

namespace App\Enums;

enum Access : string
{
    case CREATE = "CREATE" ;
    case READ = "READ" ;
    case UPDATE = "UPDATE" ;
    case DELETE = "DELETE" ;

}
