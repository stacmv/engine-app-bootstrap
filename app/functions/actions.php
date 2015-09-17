<?php
function show_home_action(){
    global $_USER;
    global $_DATA;
    global $CFG;
    
    set_topmenu_action();
    
    
}
function show_users_action(){
    global $_DATA;
    
    set_topmenu_action();
    
    $_DATA["users"] = get_users();
    
}
