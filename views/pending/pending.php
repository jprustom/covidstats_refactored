<?php 
    require_once('../../bootstrap.php');
    if (!($user->isAdmin))
        header('Location:./statsCRUD/countries_view_last_stats/countries_view_last_stats.php');
?>
<?php \Library\Configs::generateHead('Pending','../shared/images/icon.png',[
    "../shared/main.css",
    "../shared/navbar.css",
    "pending.css"
],[
    "homeLink"=>"../statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
    "statsLink"=>"../statsCRUD/statsCRUD.php",
    "countriesLink"=>"../countriesCRUD/countriesCRUD.php",
    "signInLink"=>"../auth/signIn.php",
    "memberSignUpLink"=>"../auth/signUp.php",
    "signOutLink"=>"../../controllers/auth/signOut.php",
    "editProfileLink"=>"../auth/editProfile.php",
    "pending"=>""
]) ?>

<div id="pendingAnchorTags">
    <a id="pendingAnchorTag" href='#pending-users-table'>Users</a>
    <a id="pendingAnchorTag" href='#pending-stats-tables'>/Stats</a>
</div>

<section id="pending-users-table">
    <h1>Pending Users</h1>
    <div id="pending-users-table__headers">
                <div class="pending-users-table__header user__email">Email</div>
                <div class="pending-users-table__header">Telephone</div>
                <div class="pending-users-table__header">Approve/Reject</div>
    </div>
        <?php
            require_once('../../controllers/pending/pending.php');
            if (count($pendingUsers)==0)
                print "<h1>No Users Pending For Approval</h1>";
            else
                foreach($pendingUsers as $pendingUser){
                    $pendingUserEmail=$pendingUser->email;
                    $pendingUserPhoneNumber=$pendingUser->phoneNumber;
                    $pendingUserId=$pendingUser->id;
                    $approveUserLink="../../controllers/pending/user.php?id=$pendingUserId&action=approve";
                    $rejectUserLink="../../controllers/pending/user.php?id=$pendingUserId&action=reject";
                    print"
                        <div class='pending-users-table__entries'>
                            <div class='user__email'>$pendingUserEmail</div>
                            <div>$pendingUserPhoneNumber</div>
                            <div><a href='$approveUserLink'>Approve</a>/<a href='$rejectUserLink'>Reject</a></div>
                        </div>
                    ";
                }
        ?>
</section>

<section id="pending-stats-tables">
    <section class="pending-stats-table edit-stats">
        <h1>Pending Stats To Be Edited</h1>
        <div class="pending-stats-table__headers">
                    <div class="pending-stats-table__header country">Country</div>
                    <div class="pending-stats-table__header">Date</div>
                    <div class="pending-stats-table__header">Cases</div>
                    <div class="pending-stats-table__header">Deaths</div>
                    <div class="pending-stats-table__header">Username</div>
                    <div style="font-size:1.5rem" class="pending-stats-table__header">Approve/Reject</div>
        </div>
        
            <?php
                if(count($pendingStatsToBeEdited)==0)
                    print("<h1>No Pending Stats</h1>");
                else 
                    foreach($pendingStatsToBeEdited as $pendingStatToBeEdited){
                        $countryName=ucwords($pendingStatToBeEdited->countryName);
                        $date=isset($pendingStatToBeEdited->pendingCovidStatDate)
                            ?$pendingStatToBeEdited->pendingCovidStatDate
                            :$pendingStatToBeEdited->covidstatDate;
                        $lastCases=$pendingStatToBeEdited->lastCases;
                        $lastDeaths=$pendingStatToBeEdited->lastDeaths;
                        $username=\Models\User::getUsername($pendingStatToBeEdited->userId);
                        $pendingCovidStatId=$pendingStatToBeEdited->id;
                        $approveStatLink="../../controllers/pending/stat.php?id=$pendingCovidStatId&action=approve";
                        $rejectStatLink="../../controllers/pending/stat.php?id=$pendingCovidStatId&action=reject";
                        print "
                            <div class='pending-stats-table__entries'>
                                <div class='country'>$countryName</div>
                                <div>$date</div>
                                <div>$lastCases</div>
                                <div>$lastDeaths</div>
                                <div>$username</div>
                                <div style='font-size:1.5rem'><a href='$approveStatLink'>Approve</a>/<a href='$rejectStatLink'>Reject</a></div>
                            </div>";
                            }
            ?>
        
    </section>

    <section class="pending-stats-table add-stats">
        <h1>Pending Stats To Be Added</h1>
        <div class="pending-stats-table__headers">
                    <div class="pending-stats-table__header country">Country</div>
                    <div class="pending-stats-table__header">Date</div>
                    <div class="pending-stats-table__header">Cases</div>
                    <div class="pending-stats-table__header">Deaths</div>
                    <div class="pending-stats-table__header">Username</div>
                    <div style="font-size:1.5rem" class="pending-stats-table__header">Approve/Reject</div>
        </div>

        <?php
            if(count($pendingStatsToBeAdded)==0)
                print("<h1>No Pending Stats</h1>");
            else 
                foreach($pendingStatsToBeAdded as $pendingStatToBeAdded){
                    $userId=$pendingStatToBeAdded->userId;
                    $countryId=$pendingStatToBeAdded->countryId;
                    $country=\Models\Countries::getCountry($countryId);
                    $countryName=ucwords($country->countryName);
                    $date=date('d-M-Y',strtotime($pendingStatToBeAdded->date));
                    $lastCases=$pendingStatToBeAdded->lastCases;
                    $lastDeaths=$pendingStatToBeAdded->lastDeaths;
                    $username=\Models\User::getUsername($userId);
                    $pendingCovidStatId=$pendingStatToBeAdded->id;
                    $encodedDate=urlencode($date);
                    $approveStatLink="../../controllers/pending/stat.php?id=$pendingCovidStatId&action=approve&countryId=$countryId&date=$encodedDate&cases=$lastCases&deaths=$lastDeaths&userId=$userId";
                    $rejectStatLink="../../controllers/pending/stat.php?id=$pendingCovidStatId&action=reject";
                    print "
                            <div class='pending-stats-table__entries'>
                                <div class='country'>$countryName</div>
                                <div>$date</div>
                                <div>$lastCases</div>
                                <div>$lastDeaths</div>
                                <div>$username</div>
                                <div style='font-size:1.5rem'><a href='$approveStatLink'>Approve</a>/<a href='$rejectStatLink'>Reject</a></div>
                            </div>";
                }
        ?>

    </section>
</section>