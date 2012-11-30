
$fid = DB::insert('forum_forum', array('type' => 'group', 'name' => $forumname, 'status' => 1, 'displayorder' => $_G['gp_newcatorder'][$key]), 1);
DB::insert('forum_forumfield', array('fid' => $fid));


Array ( [fup] => 84 [type] => forum [name] => 比亚迪F0 [status] => 1 [displayorder] => 0 [styleid] => 0 [allowsmilies] => 1 [allowbbcode] => 1 [allowimgcode] => 1 [allowpostspecial] => 1 [recyclebin] => 1 [allowside] => 0 [allowfeed] => 0 ) Array ( [fid] => 88 [threadtypes] => ) test