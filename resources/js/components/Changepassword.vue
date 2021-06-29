<template>
	<div class="hold-transition login-page">
	<div class="login-box">
  <div class="login-logo">
    <img class="img-fluid" src="public/dist/img/logo.png" style=" width: 100px !important;" />
     <router-link to='/' class="text-center">Laravel+Vue.js</router-link>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg text-lg">Change Password</p>
      <form @submit.prevent="onSubmit">
      	<div class="alert alert-danger" v-if="errors.length">
							<ul class="mb-0">
								<li v-for="(error,index) in errors" :key='index'>{{ error }}</li>
							</ul>
						</div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" value="" v-model="password" placeholder="Old Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" v-model="newpassword" placeholder="New Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" v-model="repassword" placeholder="Re-Enter Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Change</button>
          </div>
        </div>
      </form>
      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
    </div>
  </div>
</div>
</div>

</template>

<script>
	export default{
		name:'changepassword',
		props: ['app'],
		data(){
			return{
                password:'',
                newpassword:'',
                repassword:'',
				errors:[],
			}
		},
		methods:{
			onSubmit(){
				this.errors=[];
				
				if (!this.password) {
					this.errors.push('Password is Required');
				}
				if (!this.newpassword) {
					this.errors.push('New Password is Required');
                }
				if (!this.repassword) {
					this.errors.push('Re-Enter Password is Required');
                }
                if (this.newpassword != this.repassword) {
					this.errors.push('Two Password is Not Same');
				}

				if (!this.errors.length) {
					const data = {
                        password:this.password,
                        newpassword:this.newpassword,
					}

					axios.post('auth/changepassword',data).then(response =>{
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