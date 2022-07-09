<template>
  <main class="bg_gray">
    <div class="container" style="padding-top: 170px">
      <paginate
        id="myTable"
        ref="myTable"
        classx="table table-bordered table-striped table-hover rounded"
        :columns="columns"
        url="/transaksi/kasirIndex"
        :callback="callback"
        :useCard="true"
      ></paginate>
    </div>
  </main>
</template>

<script>
import axios from "axios";
import paginate from "../../components/Paginate.vue";

export default {
  components() {
    paginate;
  },
  data() {
    return {
      columns: [
        { name: "kode", data: "kd_transaksi" },
        { name: "nama", data: "nama_pembeli" },
        { name: "Tipe pembayaran", data: "type_transaksi" },
        { name: "total", data: "total_harga" },
        { name: "nomor meja", data: "meja.no_meja" },
        { name: "status", data: "statusT" },
        { name: "Aksi", data: "action", style: "width: 175px" },
      ],
      type: "tambah",
      show: false,
      datasiswa: [],
      datakelas: [],
      form: {},
    };
  },
  methods: {
    Test() {
      this.$router.push({name:'home'})
    },
    callback() {
      // Callback Example
      var app = this;
      $("#myTable").on("click", ".delete", function (e) {
        var id = $(this).data("id");

            axios
              .post("transaksi/kasirUpdate", { data: id })
              .then((res) => {
                app.$refs.myTable.reload();
              })
              .catch((err) => {});
         

      });
    },
  },
};
</script>
