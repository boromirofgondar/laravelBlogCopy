<?php

namespace App\Http\Controllers;

# no using this class for anything, but given ref to it by default...
//use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    public function index(){

        $tasks = Task::all();
        return view('databast.database', compact('tasks'));

    }

//    public function show($id){
//          /*
//           * Note that 'find' will by default go by the primary key of the resp table,
//           * which in this case, happens to be 'id'
//           */
//        $task =Task::find($id);
//        return view('databast.datasing', compact('task'));
//    }

    /*
     * Same as above 'show' function, but we take advantage of the wildcard
     * used in web.php, which is assumed to be a column within the 'task' table
     * so that we are basically doing
     * $task = Task::find('wildcard_value')  // which returns a Task object
     * which is then what has been passed as a parameter to the callback here,
     * rather than a vanilla 'wildcard' entry value (string)
     *
     * >Here is where it is important that the wildcard value used is the same, and not arbitrary
     * */
    public function show(Task $task){
        return view('databast.datasing', compact('task'));
    }


}
