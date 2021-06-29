<template>
	<div class="hold-transition register-page">
	<div class="register-box">
  <div class="register-logo">
    <img class="img-fluid" src="public/dist/img/logo.png" style=" width: 100px !important;" />
    <router-link to='/' class="text-center">Laravel+Vue.js</router-link>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg text-lg">Register</p>

      <form @submit.prevent="onSubmit">
      	<div class="alert alert-danger" v-if="errors.length">
			<ul class="mb-0">
				<li v-for="(error,index) in errors" :key='index'>{{ error }}</li>
			</ul>
		</div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" v-model="name" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" v-model="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" v-model="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" v-model="cnfpassword" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <router-link to='/login' class="text-center">I already have a Account</router-link>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
</div>
</template>

<script>
	export default {
		name:'register',
		props: ['app'],
		data(){
			return{
				name:'',
				email:'',
				password:'',
				cnfpassword:'',
				errors:[],
			}
		},
		methods:{
			onSubmit(){
				this.errors=[];
				if (!this.name) {
					this.errors.push('Name is Required');
				}
				if (!this.email) {
					this.errors.push('E-mail is Required');
				}
				if (!this.password) {
					this.errors.push('Password is Required');
				}
				if (!this.cnfpassword) {
					this.errors.push('Conform Password is Required');
				}
				if (this.password !== this.cnfpassword) {
					this.errors.push('Password Do Not Match');
				}

				if (!this.errors.length) {
					const data = {
						name: this.name,
						email: this.email,
						password: this.password,
					}

					axios.post('auth/register',data).then(response =>{
						this.app.user = response.data;
						this.$router.push('/');
					}).catch(error => {
						this.errors.push(error.response.data.error);
					});
				}
			}
		}
	}
</script>