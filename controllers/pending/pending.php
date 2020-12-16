<?php if (!$user->isAdmin)
        header('Location:../../views/auth/signIn.php');?>
<?php 
    try{
        $pendingUsers=\Models\User::getPendingUsers();
        $pendingStatsToBeEdited=\Models\CovidStats::getPendingStatsToEdit();
        $pendingStatsToBeAdded=\Models\CovidStats::getPendingStatsToAdd();
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }
?>