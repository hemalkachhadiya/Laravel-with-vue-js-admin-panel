<template>
	<div class="hold-transition login-page">
	<div class="login-box">
  <div class="login-logo">
        <img class="img-fluid" style=" width: 100px !important;"  src="public/dist/img/logo.png" />
     <router-link to='/' class="text-center">Laravel+Vue.js</router-link>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg text-lg">Sign in</p>
      <form @submit.prevent="onSubmit">
      	<div class="alert alert-danger" v-if="errors.length">
							<ul class="mb-0">
								<li v-for="(error,index) in errors" :key='index'>{{ error }}</li>
							</ul>
						</div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" value="" v-model="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" v-model="Password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <router-link to='/register' class="text-center">Register</router-link>
      </p>
    </div>
  </div>
</div>
</div>

</template>

<script>
	export default{
		name:'login',
		props: ['app'],
		data(){
			return{
				email:'',
				Password:'',
				errors:[],
			}
		},
		methods:{
			onSubmit(){
				this.errors=[];
				
				if (!this.email) {
					this.errors.push('E-mail is Required');
				}
				if (!this.Password) {
					this.errors.push('Password is Required');
				}

				if (!this.errors.length) {
					const data = {
						email:this.email,
						password:this.Password,
					}

					axios.post('auth/login',data).then(response =>{
            this.app.user = response.data;
            this.$store.state.user = response.data;
            console.log(this.$store.state.user);
             this.$router.push("/dashboard");
					}).catch(error => {
						this.errors.push(error.response.data.error);
					});
				}
			}
		}
	}
</script>
<style scoped>

</style>