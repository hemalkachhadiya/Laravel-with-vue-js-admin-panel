<template>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Menu-type</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Menu-type</li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
   <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Change Image</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
           <div v-if="upload">
                  <img class="img-thumbnail" width="500px" height="500px" :src="url" alt="preview" />
                </div>
                <div v-else>
          <div v-if="changeimage != null">
            <img
              class="img-thumbnail"
              width="500px"
              height="500px"
              :src="'public/images/' + changeimage"
              alt="preview"
            />
          </div>
          <div v-else>
            <h1>No Image Avariable For This Data</h1>
          </div>
                </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <form method="POST"
            id="form_data"
            enctype="multipart/form-data"
            @submit.prevent="onSubmit">
             <div class="btn btn-file btn-primary">
                    <input
                      type="file"
                      class="custom-file-input"
                      id="customFile"
                      accept="image/*"
                      v-on:change="onImageChange"
                    />Browser
                  </div>
          <button type="submit" name="submit" class="btn btn-success" @click="onSubmit" data-dismiss="modal">Submit</button>
          </form>
        </div>
        
      </div>
    </div>
  </div>


    <section>
      <vue-bootstrap4-table
        ref="myvuetable"
        :rows="rows"
        :columns="columns"
        :config="config"
        @on-change-query="onChangeQuery"
        :total-rows="total_rows"
        @on-select-row="selectedRow()"
        @on-all-select-rows="selectedall(rows)"
      >
        <template slot="card-header">
          <a class="btn btn-danger btn-sm float-left" @click="muldelete()"
            ><i class="fa fa-trash">&nbsp;</i>Delete</a
          >
          <a
            href="#/menu-types/create"
            class="btn btn-success btn-sm float-right"
            ><i class="fa fa-plus">&nbsp;</i>Add</a
          >
        </template>
        <template slot="card-body" class="tablebody">
        </template>
        <template slot="image-slot" slot-scope="props">
          <div v-if="props.cell_value != null">
            <img
              class="img-thumbnail"
              width="100px"
              height="100px"
              :src="'public/images/' + props.cell_value"
              alt="preview"
               data-toggle="modal" data-target="#myModal"
               @click="openmodal(props.row.image, props.row.id)"
            />
          </div>
          <div v-else>
            <a class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#myModal" @click="openmodal(props.row.image, props.row.id)">
              <i class="fa fa-plus" aria-hidden="true"></i>
            </a>
          </div>
        </template>
        <template slot="date-slot" slot-scope="props">
          {{ format_date(props.cell_value) }}
        </template>
        <template slot="action-slot" slot-scope="props">
          <a
            :href="'#/menu-types/edit/' + props.cell_value"
            class="btn btn-primary btn-sm"
            ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a
          >
          <button
            type="button"
            class="btn btn-danger btn-sm"
            @click="onDelete(props.cell_value)"
          ><i class="fa fa-trash" aria-hidden="true"></i> Delete
          </button>
        </template>
      </vue-bootstrap4-table>
    </section>
  </div>
</template>

<script>
import VueBootstrap4Table from "vue-bootstrap4-table";

export default {
  name: "menu_types",
  props: ["app"],
  components: {
    VueBootstrap4Table,
  },
  data: function () {
    return {
      errors: "",
      danger: "",
      delid: "",
      rows: [],
      changeimage: "",
      changeid: "",
      upload: false,
      url: "",
      image: "",
      columns: [
        {
          label: "id",
          name: "id",
          sort: true,
        },
        {
          label: "Image",
          name: "image",
          sort: false,
          slot_name: "image-slot",
        },
        {
          label: "Name",
          name: "name",
          sort: true,
        },
        {
          label: "Date",
          name: "created_at",
          sort: true,
          slot_name: "date-slot",
        },
        {
          label: "Actions",
          name: "id",
          slot_name: "action-slot",
        },
      ],
      events: {
        selected_items: true,
      },
      config: {
        checkbox_rows: true,
        // multi_column_sort: true,
        server_mode: true, // by default false
        selected_rows_info: true,
        show_refresh_button: false,
        show_reset_button: false,
      },
      queryParams: {
        sort: [],
        global_search: "",
        per_page: 10,
        page: 1,
      },
      total_rows: 0,
      selected_items: [],
    };
  },
  methods: {
    onSubmit(){
      let data = new FormData();
        data.append("image", this.image);
        data.append("id", this.changeid);
      console.log(data);
      axios
          .post("api/menu-types/changeimage", data)
          .then((response) => {
            this.fetchData();
            swal("", response.data, "success");
          })
          .catch((error) => {
            this.errors.push(error.response.data.error);
          });
    },
     onImageChange(e) {
      this.image = e.target.files[0];
      this.url = URL.createObjectURL(this.image);
      this.upload = true;
    },
    openmodal(changeimage, changeid) {
      this.url = "",
      this.upload = false;
      this.image = "",
      this.changeimage = changeimage;
      this.changeid = changeid;
      e.preventDefault();
    },
    selectedRow() {
      this.selected_items = this.$refs.myvuetable.selected_items;
      console.log(this.selected_items);
    },
    selectedall(item) {
      console.log(item);
      //alert(item);
    },
    onChangeQuery(queryParams) {
      this.queryParams = queryParams;
      this.fetchData();
    },
    fetchData() {
      let self = this;
      axios
        .get("api/menu-types", {
          params: {
            queryParams: this.queryParams,
            page: this.queryParams.page,
          },
        })
        .then(function (response) {
          self.rows = response.data.data.data;
          self.total_rows = response.data.data.total;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    format_date(value) {
      if (value) {
        return moment(String(value)).format("DD/MM/YYYY");
      }
    },
    muldelete() {
      const data = {
        selected_items: this.selected_items,
      };

      axios
        .post("api/menu-types/muldelete", data)
        .then((response) => {
          this.fetchData();
          console.log(response);
          swal("", response.data, "success");
        })
        .catch((error) => {
          console.log(error.response);
        });
    },
    onDelete(id) {
      this.delid = id;
      axios
        .get("api/menu-types/delete/" + this.delid)
        .then((response) => {
          this.fetchData();
          console.log(response);
          swal("", response.data, "success");
        })
        .catch((error) => {
          console.log(error.response);
        });
    },
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style>
.card-header{
  border-bottom: none;
}

.has-clear-right{
  margin-bottom: 0px;
}
</style>