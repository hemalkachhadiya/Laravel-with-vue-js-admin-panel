<template>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Menu Type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#/dashboard">Home</a></li>
              <li class="breadcrumb-item active">
                <a href="#/menu-types">Menu-type</a>
              </li>
              <li class="breadcrumb-item active">Add Menu Type</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="col-md-12 row">
        <div class="col-md-6">
          <form
            method="POST"
            id="form_data"
            enctype="multipart/form-data"
            @submit.prevent="onSubmit"
          >
            <div class="card">
              <div class="card-header" v-if="errors.length">
                <ul class="alert alert-danger alert-dismissible fade show">
                  <li v-for="error in errors" style="list-style: none">
                    {{ error }}
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>Name</label>
                  <input
                    type="text"
                    class="form-control"
                    name="name"
                    v-model="name"
                  />
                </div>
                <div v-if="upload == true">
                  <img
                    class="img-thumbnail"
                    width="240px"
                    height="240px"
                    :src="url"
                    alt="preview"
                  />
                </div>
                <div class="form-group">
                  <label>Image</label>
                  <br />
                  <div class="btn btn-file btn-primary">
                    <input
                      type="file"
                      class="custom-file-input"
                      id="customFile"
                      accept="image/*"
                      v-on:change="onImageChange"
                    />Browser
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">
                    <i class="fa fa-check"> &nbsp;</i>Submit
                  </button>
                  <button
                    type="button"
                    name="back"
                    onClick="javascript:history.go(-1);"
                    class="btn btn-secondary"
                  >
                    <i class="fa fa-chevron-circle-left"> &nbsp;</i>Back
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: "create_Menu_types",
  data() {
    return {
      name: "",
      image: "",
      url: null,
      upload: false,
      errors: [],
    };
  },
  methods: {
    onImageChange(e) {
      this.image = e.target.files[0];
      this.url = URL.createObjectURL(this.image);
      this.upload = true;
    },
    onSubmit() {
      this.errors = [];
      if (!this.name) {
        this.errors.push("Name required.");
      }
      if (!this.image) {
        this.errors.push("Image required.");
      }
      if (!this.errors.length) {
        let data = new FormData();
        data.append("image", this.image);
        data.append("name", this.name);
        axios
          .post("api/menu-types/store", data)
          .then((response) => {
            this.$router.push("/menu-types");
            swal("", response.data, "success");
          })
          .catch((error) => {
            this.errors.push(error.response.data.error);
          });
      }
    },
  },
};
</script>

<style>
</style>