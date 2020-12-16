<?php if (!isset($_SESSION['user']) || !$user->isAdmin)
        header('Location:../../index.php');?>
<?php 
    try{
        $pendingUsers=\Models\User::getPendingUsers();
        $pendingStatsToBeEdited=\Models\PendingCovidStats::getPendingStatsToEdit();
        $pendingStatsToBeAdded=\Models\PendingCovidStats::getPendingStatsToAdd();
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }
?>