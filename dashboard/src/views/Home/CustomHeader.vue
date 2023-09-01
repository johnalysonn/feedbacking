<template>
    <section>
        <header>
            <nav class="navbar navbar-expand-lg bg-transparent" style="padding: 30px 100px">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><img src="../../assets/images/logo_white.png"  alt="Logo" style="width: 20%"></a>
                    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item me-4">
                                <a 
                                @click="() => emit('create-account')"
                                class="nav-link text-white" aria-current="page" href="#">Crie uma conta</a>
                            </li>
                            <li class="nav-item">
                                <a 
                                @click="() => emit('login')"
                                class="nav-link rounded rounded-pill px-4 bg-white a-hover" id="a-link" aria-current="page" href="#">Entrar</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="d-flex justify-content-center align-items-center" style="padding: 0 50px">

            <div class="col-md-6 d-flex justify-content-center flex-column" style="width: 40%">
                <div class="mb-3">
                    <div class="mb-3">
                        <h1 class="fw-bolder">Tenha um feedback.</h1>
                        <h1 class="fw-bolder">E faça seus clientes mais felizes!</h1>
                    </div>

                    <p>Receba ideias, reclamações e feedbacks com um simples widget na página.</p>
                </div>
                <div>
                    <a 
                    @click="() => emit('create-account')"
                    href="#" id="a-link" class="a-hover text-decoration-none p-2 rounded rounded-pill px-4 bg-white">Crie uma conta grátis</a>
                </div>
            </div>

            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img src="../../assets/images/blue_ballons.png" class="w-75" alt="">
            </div>
        </div>
    </section>
</template>
<script>
export default {
    setup (_, { emit }){
        return{emit}
    }
}
</script>

<style scoped>
*{
    color: #fff;
}
section{
    background-color: rgba(239, 73, 131, 1);
}
a#a-link{
    color: #ef4983;
}

</style>