 <template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#/dashboard" class="brand-link align-items-center">
      <span class="brand-text font-weight-light">Laravel+Vue.js</span>
    </a>

    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input
            class="form-control form-control-sidebar"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li
            class="nav-item"
            v-for="tab in tabs"
            v-if="tab.type == '0' && tab.status == '1'"
          >
            <router-link :to="'/' + tab.url" class="nav-link">
              <i :class="['nav-icon fas fa-' + tab.icon]"></i>
              <p>
                {{ tab.name }}
              </p>
            </router-link>
          </li>
          <li
            class="nav-item has-treeview"
            v-else-if="tab.type == '1' && tab.status == '1'"
          >
            <a class="nav-link">
              <i :class="['nav-icon fas fa-' + tab.icon]"></i>
              <p>
                {{ tab.name }}
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li
                class="nav-item"
                v-for="newtab in tabs"
                v-if="
                  newtab.type == '2' && newtab.status == '1' && tab.id == newtab.tab_id
"
              >
              <router-link :to="'/' + newtab.url" class="nav-link" >
              <i :class="['nav-icon fas fa-' + newtab.icon]"></i>
                  <p>
                    {{ newtab.name }}
                  </p>
              </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
  </aside>
</template>
 
 <script>
export default {
  data: function () {
    return {
      tabs: {},
    };
  },
  mounted() {
    this.loadtabs();
  },
  methods: {
    loadtabs() {
      axios
        .get("api/tabs")
        .then((response) => {
          this.tabs = response.data.data;
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
          this.danger = true;
        });
    },
  },
};
</script>
 
 