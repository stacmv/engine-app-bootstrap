<?php
function show_home_action(){
    global $_USER;
    global $_DATA;
    global $CFG;
    
        
    
}

function show_dashboard_action(){
    global $_USER;
    global $_DATA;
    global $CFG;
    
    
    
    
}
function show_users_action(){
    global $_DATA;
        
    $_DATA["users"] = get_users();
    
}


register_default_action("set_topmenu");