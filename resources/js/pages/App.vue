<template>
    <main>
         <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <router-link to="/" class="logo">
                            <img src="/images/logo.png" alt="logo" height="66" width="66">
                        </router-link>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="index.html" class="active">Home</a></li>
                            <li><a href="explore.html">Explore</a></li>
                            <li><a href="details.html">Item Details</a></li>
                            <li><a href="author.html">Author</a></li>
                            <li><a href="create.html">Create Yours</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <router-view></router-view>
    </main>
</template>

<script>
export default {
    mounted(){
        console.log('sukses');
    }
}
</script>