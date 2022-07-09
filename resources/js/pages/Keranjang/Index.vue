<template>
  <div class="bg_gray">
    <div class="container margin_detail" style="padding-top: 150px">
      <div class="row">
        <div class="col-lg-8 list_menu">
          <section id="section-1">
            <h4>Starters</h4>
            <div class="table_wrapper">
              <table class="table cart-list menu-gallery">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="data in dataKeranjang">
                    <td class="d-md-flex align-items-center">
                      <figure>
                        <a
                          href="img/menu_item_large_1.jpg"
                          title="Photo title"
                          data-effect="mfp-zoom-in"
                          ><img
                            :src="data.foto_dir"
                            data-src="img/menu-thumb-1.jpg"
                            alt="thumb"
                            class="lazy"
                        /></a>
                      </figure>
                      <div class="flex-md-column">
                        <h4>{{ data.nama }}</h4>
                        <p>
                          {{ data.harga }}
                        </p>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input
                          type="number"
                          class="form-control"
                          v-model="data.qty"
                          @input="inputchange($event, data.id)"
                          oninput="this.value = this.value.replace(/\D/g, '')"
                          style="width: 70px"
                        />
                      </div>
                    </td>
                    <td class="options">
                      <div class="dropdown dropdown-options">
                        <a
                          href="javascript:void(0)"
                          @click.prevent="hapus(data.id)"
                          class="dropdown-toggle"
                          ><i class="icon_trash_alt"></i
                        ></a>
                      </div>
                    </td>
                  </tr>
                  <tr v-if="dataKeranjang.length == 0" >
                    <td colspan="4"><h4 class="text-center">
                      Tidak ada data
                    </h4></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
          <!-- /section -->
        </div>
        <!-- /col -->

        <div class="col-lg-4" id="sidebar_fixed">
          <div class="box_order mobile_fixed">
            <div class="head">
              <h3>Order Summary</h3>
              <a href="#0" class="close_panel_mobile"
                ><i class="icon_close"></i
              ></a>
            </div>
			<form @submit.prevent="transaksi()">
            <!-- /head -->
            <div class="main">
              <ul class="clearfix">
                <li v-for="data in dataKeranjang">
                  <a href="#0">{{ data.qty }}x {{ data.nama }}</a
                  >&nbsp;<span> Rp.{{ parseInt(data.harga) * parseInt(data.qty) }}</span>
                </li>
              </ul>
              <div class="row opt_order">
                <div class="col-6">
                  <label class="container_radio"
                    >tunai
                    <input
						v-model="form.type"
                      type="radio"
                      value="tunai"
                      name="opt_order"
                      checked
                    />
                    <span class="checkmark"></span>
                  </label>
                </div>
                <div class="col-6">
                  <label class="container_radio"
                    >non tunai
                    <input type="radio" value="non_tunai" name="opt_order" v-model="form.type"  />
                    <span class="checkmark"></span>
                  </label>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-12 col-sm-12 col-lg-12">
                  <label>Nama</label>
                  <input type="text" class="form-control" v-model="form.nama" name="name" required placeholder="Nama" />
                </div>
                <div class="form-group col-md-12 col-sm-12 col-lg-12">
                  <label>Alamat <small>(opsional)</small></label>
                  <input
				  v-model="form.alamat"
                    type="text"
					name="alamat"
                    class="form-control"
                    placeholder="Alamat"
                  />
                </div>
                <div class="form-group col-md-12 col-sm-12 col-lg-12">
                  <label>Phone <small>(opsional)</small></label>
                  <input
				  v-model="form.phone"
                    type="text"
					name="phone"
                    class="form-control"
                    placeholder="no telp"
                  />
                </div>

                <div class="form-group col-md-12">
                  <label for="">Meja</label>
                  <select
				  v-model="form.meja"
				  required
                    class="form-select"
                    aria-label="Default select example"
                  >
                    <option selected>silahkan pilih meja</option>
                    <option v-for="data in meja" :value="data.id">
                      No {{ data.no_meja }} -
                      {{ data.halaman.nm_halaman_meja }} -
                      {{ data.type.nm_type_meja }}
                    </option>
                  </select>
                </div>
              </div>
              <!-- /dropdown -->
              <!-- /dropdown -->
              <div class="btn_1_mobile">
                <button
                  class="pesan btn_1 gradient full-width mb_5"
                  type="submit"
                  >Pesan Sekarang</button
                >
                <div class="text-center">
                  <small>No money charged on this steps</small>
                </div>
              </div>
            </div>
		  </form>
          </div>
          <!-- /box_order -->
          <div class="btn_reserve_fixed">
            <a href="#0" class="btn_1 gradient full-width">View Basket</a>
          </div>
        </div>
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
</template>

<style scoped>
section {
  margin-top: 0;
}
</style>

<script>
import axios from "axios";
import Swal from "sweetalert2";
export default {
  data() {
    return {
      dataKeranjang: [],
      meja: [],
	  form: {
    alamat: "",
    phone: "",
		type: 'tunai'
	  }
    };
  },
  methods: {
    transaksi() {
	var app = this;
     if(app.form.meja == '' || app.form.nama == ''){
		          Swal.fire({
            icon: "error",
            title: "oopss..",
            text: "sesuatu error terjadi",
          });
	 } else {
		if($( window ).width() <= 992){
			$(".box_order").hide();
		}
		Swal.fire({
  title: 'Apakah kamu yakin',
  text: "Kamu tidak bisa mengulang tahap ini, silahkan cek pesanan anda",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Iya, Saya Mau Pesan'
}).then((result) => {
  if (result.isConfirmed) {
		axios.post('keranjang/transaksi', {data: app.dataKeranjang, form: app.form}).then((res) => {
			app.$router.push({name: 'transaksi'});
			setTimeout(() => {
				Swal.fire({icon: 'success', title: 'yeyyyy..', text: 'silahkan membayar transaksi'});
			},500)
		});
  }
})
	 }
    },
    inputchange(event, id) {
      var app = this;
      var index;
      index = app.dataKeranjang.findIndex((cat) => cat.id == id);
      if (event.target.value == "" || event.target.value == "0") {
        console.log(index);
        this.dataKeranjang[index].qty = "1";
      }
    },
    getMeja() {
      var app = this;

      axios
        .get("keranjang/getMeja")
        .then((res) => {
          app.meja = res.data.data;
        })
        .catch((err) => {
          Swal.fire({ icon: "error", title: "sesuatu error terjadi" });
        });
    },
    hapus(id) {
      var app = this;
      var arr = app.dataKeranjang;
      var data = [];
      var index;
      index = app.dataKeranjang.findIndex((cat) => cat.id == id);
      arr.splice(index, 1);

      for (let i = 0; i < arr.length; i++) {
        data.push(arr[i].id);
      }

      console.log(data);

      axios
        .post("keranjang/hapus", { data: data })
        .then((res) => {})
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "oopss..",
            text: "sesuatu error terjadi",
          });
        });
    },
    load() {
      $(".btn_reserve_fixed a").on("click", function () {
        $(".box_order").show();
      });
      $(".close_panel_mobile").on("click", function (event) {
        event.stopPropagation();
        $(".box_order").hide();
      });
    },
    index() {
      var app = this;
      axios.get("keranjang/index").then((res) => {
        app.dataKeranjang = res.data.data;
      });
    },
  },
  mounted() {
    var app = this;
    app.index();
    app.getMeja();
    app.load();
  },
};
</script>