<template>
  <main>
    <div class="hero_single version_1 bg-light">
      <div class="opacity-mask">
        <div class="container">
          <div class="row justify-content-lg-start justify-content-md-center">
            <div class="col-xl-6 col-lg-8">
              <h1>Cafe Melati</h1>
              <p>Cafe yang menyediakan self order dari meja anda</p>
            </div>
          </div>
          <!-- /row -->
        </div>
      </div>
      <div class="wave hero"></div>
    </div>
    <div class="container margin_30_60">
      <div class="main_title center">
        <span><em></em></span>
        <h2>Menu Favorit</h2>
        <p class="text-dark">
          Menu yang sering di beli oleh pelanggan cafe kami
        </p>
      </div>

      <carousel
        v-if="carousel"
        :autoplay="true"
        :responsive="{
          200: { items: 1, nav: false },
          600: { items: 1, nav: false },
          800: { items: 2 },
          1200: { items: 3 },
          1500: { items: 4 },
        }"
      >
        <div class="card" v-for="data in favorit">
          <div class="imgBx">
            <img
              :src="data.foto_dir"
              :alt="data.foto_dir"
            />
          </div>

          <div class="contentBx">

            <div class="size">
              <h2>{{data.nama}}</h2>
            </div>
              <div class="size">
                
                <h3>{{data.transaksi_count}}x dibeli</h3>
            </div>
          </div>
        </div>
      </carousel>
      <!-- /main_title -->
      <div class="main_title center mt-3">
        <span><hr /></span>
        <h2>Pilihan Menu</h2>
        <p class="text-dark">
          Inilah pilihan menu terbaik yang ada di cafe kami
        </p>
        <span><em></em></span>
      </div>

      <!-- /carousel -->
    </div>
    <div class="container margin_30_20">
      <div class="row">
        <aside class="col-lg-3" id="sidebar_fixed">
          <!-- /type_delivery -->

          <a href="javascript:void(0)" class="open_filters btn_filters"
            ><i class="icon_adjust-vert"></i><span>Filters</span></a
          >

          <div class="filter_col">
            <div class="inner_bt clearfix">
              Filters<a href="#" class="open_filters"
                ><i class="icon_close"></i
              ></a>
            </div>
            <div class="filter_type">
              <h4>
                <a href="#filter_1" data-toggle="collapse" class="opened"
                  >Sort</a
                >
              </h4>
              <div class="collapse show" id="filter_1">
                <ul>
                  <li>
                    <label class="container_radio"
                      >Reccomended
                      <input
                        type="radio"
                        v-model="filter.sort"
                        value="1"
                        name="filter_sort"
                        :checked="filter.sort == '1'"
                      />
                      <span class="checkmark"></span>
                    </label>
                  </li>
                  <li>
                    <label class="container_radio"
                      >Price: low to high
                      <input
                        type="radio"
                        name="filter_sort"
                        v-model="filter.sort"
                        value="2"
                        :checked="filter.sort == '2'"
                      />
                      <span class="checkmark"></span>
                    </label>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /filter_type -->
            <div class="filter_type last">
              <h4>
                <a href="#filter_2" data-toggle="collapse" class="closed"
                  >Tipe Makanan <small v-if="filter.type.length > 0">({{filter.type.length}} terpilih)</small></a
                >
              </h4>
              <div class="collapse" id="filter_2">
                <ul>
                  <li v-for="data in typeMenu">
                    <label class="container_check"
                      >{{data.nm_type}} <small>{{data.menu_count}}</small>
                      <input type="checkbox" :value="data.id" @change="typemenu(data.id)" />
                      <span class="checkmark"></span>
                    </label>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /filter_type -->

            <!-- /filter_type -->
            <p><a href="javascript:void(0)" class="btn_1 outline full-width" @click.prevent="index()">Filter</a></p>
          </div>
        </aside>

        <div class="col-lg-9">
          <!-- /promo -->

          <div class="row">

            <!-- /strip grid -->
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6" v-for="data in data_menu">
              <div class="strip">
                <figure>
                  <img
                    :src="data.foto_dir"
                    data-src="img/location_2.jpg"
                    class="img-fluid lazy"
                    alt=""
                  />
                  <a href="detail-restaurant.html" class="strip_info">
                    <small>{{data.type.nm_type}}s</small>
                    <div class="item_title">
                      <h3>{{data.nama}}</h3>
                      <small>Rp. {{String(data.harga).replaceAll(/\B(?=(\d{3})+(?!\d))/g, '.')}}</small>
                    </div>
                  </a>
                </figure>
                <ul>
                  <li>
                    <span :class="data.status == 1 ? 'take': 'take no'">{{data.status == 1 ? 'tersedia': 'tidak tersedia'}}</span>
                  </li>
                  <li>
                    <a href="#0" class="btn_1 outline" v-if="data.status == 1" @click="keranjang(data.id)">masukan keranjang</a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /strip grid -->
            <!-- /strip grid -->
			</div>
          <!-- /row -->
          
        </div>
        <!-- /col -->
      </div>
    </div>
  </main>
</template>

<style scoped>
.owl-theme .owl-nav [class*="owl-"] {
  border-radius: 50%;
}
.container {
  position: relative;
}

.container .card {
  position: relative;
  width: 320px;
  height: 450px;
  margin: auto;
  background: #052e00;
  border-radius: 20px;
  overflow: hidden;
}

.container .card:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: #68c44459;
  clip-path: circle(150px at 80% 20%);
  transition: 0.5s ease-in-out;
}

.container .card:hover:before {
  clip-path: circle(300px at 80% -20%);
}

.container .card:after {
  content: "CfMlt";
  position: absolute;
  top: 30%;
  left: -20%;
  font-size: 12em;
  font-weight: 800;
  font-style: italic;
  color: rgba(255, 255, 255, 0.04);
}

.container .card .imgBx {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1000;
  width: 100%;
  height: 100%;
  transition: 0.5s;
}

.container .card:hover .imgBx {
  top: 0%;
  transform: translateY(-25%);
  /* bug  */
}

.container .card .imgBx img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(20deg);
  width: 270px;
}

.container .card .contentBx {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 100px;
  text-align: center;
  transition: 1s;
  z-index: 90;
}

.container .card:hover .contentBx {
  height: 210px;
}

.container .card .contentBx h2 {
  position: relative;
  font-weight: 600;
  letter-spacing: 1px;
  color: #fff;
}

.container .card .contentBx .size,
.container .card .contentBx .color {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 8px 20px;
  transition: 0.5s;
  opacity: 0;
  visibility: hidden;
}

.container .card:hover .contentBx .size {
  opacity: 1;
  visibility: visible;
  transition-delay: 0.5s;
}

.container .card:hover .contentBx .color {
  opacity: 1;
  visibility: visible;
  transition-delay: 0.6s;
}

.container .card .contentBx .size h3,
.container .card .contentBx .color h3 {
  color: white;
  font-weight: 300;
  font-size: 14px;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-right: 10px;
}

.container .card .contentBx .size span {
  width: 26px;
  height: 26px;
  text-align: center;
  line-height: 26px;
  font-size: 14px;
  display: inline-block;
  color: #111;
  background: #fff;
  margin: 0 5px;
  transition: 0.5s;
  color: #111;
  border-radius: 4px;
  cursor: pointer;
}

.container .card .contentBx .size span:hover {
  /* other bug */
  background: #b90000;
}

.container .card .contentBx .color span {
  width: 20px;
  height: 20px;
  background: #ff0;
  border-radius: 50%;
  margin: 0 5px;
  cursor: pointer;
}

.container .card .contentBx .color span:nth-child(2) {
  background: #1bbfe9;
}

.container .card .contentBx .color span:nth-child(3) {
  background: #1b2fe9;
}

.container .card .contentBx .color span:nth-child(4) {
  background: #080481;
}

.container .card .contentBx a {
  display: inline-block;
  padding: 10px 20px;
  background: #fff;
  border-radius: 4px;
  margin-top: 10px;
  text-decoration: none;
  font-weight: 600;
  color: #111;
  opacity: 0;
  transform: translateY(50px);
  transition: 0.5s;
}

.container .card:hover .contentBx a {
  opacity: 1;
  transform: translateY(0px);
  transition-delay: 0.7s;
}
</style>

<script>
import axios from "axios";
import carousel from "vue-owl-carousel";

export default {
  components: { carousel },
  data() {
    return {
      carousel: false,
      transaksi: null,
      typeMenu: [],
      favorit: [],
      filter: {
        sort: 1,
        type: [],
      },
      data_menu: [],
    };
  },
  methods: {
    owl() {
      $("a.open_filters").on("click", function () {
        $(".filter_col").toggleClass("show");
        $(".layer").toggleClass("layer-is-visible");
      });

      var $headingFilters = $(".filter_type h4 a");
      $headingFilters.on("click", function () {
        $(this).toggleClass("opened");
      });
      $headingFilters.on("click", function () {
        $(this).toggleClass("closed");
      });
    },
    getTypeMenu() {
      var app = this;
      axios
        .get("home/getTypeMenu")
        .then((res) => {
          app.typeMenu = res.data.data;
        })
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Sesuatu error Terjadi!",
          });
        });
    },
	keranjang(id){
		axios.get("home/keranjang/"+id).then((res) => {
			Swal.fire({
				 icon: "success",
            title: "Berhasil",
            text: "Berhasil menambah ke keranjang",
			})
		}).catch((err) => {
			Swal.fire({
				icon: 'error',
				title: 'Oppss..',
				text: err.response.data.data
			})
		})
	},
	typemenu(id){
		var app = this;
		var index = app.filter.type.indexOf(id);
		if (index !== -1) {
			app.filter.type.splice(index, 1);
		} else {
			app.filter.type.push(id);
		}
		console.log(app.filter.type);
	},	
    index() {
      var app = this;
      axios
        .post("home/index", { data: app.filter })
        .then((res) => {
          app.data_menu = res.data.data;
        })
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Sesuatu error Terjadi!",
          });
        });
    },
    fav() {
      var app = this;
      axios
        .get("home/favorit")
        .then((res) => {
          app.favorit = res.data.data;
          app.carousel = true;
        })
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Sesuatu error Terjadi!",
          });
        });
    },
  },
  mounted() {
    var app = this;

    app.owl();
	app.getTypeMenu();
    app.index();
    app.fav();

    //    var payButton = document.getElementById('pay-button');
    // payButton.addEventListener('click', function () {
    //   // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
    //   window.snap.pay(app.transaksi);
    //   console.log(app.transaksi);
    //   // customer will be redirected after completing payment pop-up
    // });
  },
};
</script>