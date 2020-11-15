
<section id="navbar">
    <img src=<?php echo(($inside_routes?'..':'.')."/images/icon.png") ?> />
    <nav id="links">
        <a id="home" href=<?php echo(getPathToHome()); ?>>Last Stats</a>
        <a href=<?php echo(getPathToRoutes("add_stats")); ?>>Add Stats</a>
        <a href=<?php  echo(getPathToRoutes("add_country")); ?>>Add Country</a>
    </nav>
</section>

<script>
    document.querySelector('#navbar>img').addEventListener('click',()=>{
        document.getElementById('home').click();
    });
</script>

