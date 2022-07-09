<template>
  <main class="bg_gray">
    <div class="container" style="padding-top: 170px">
      <paginate
        id="myTable"
        ref="myTable"
        classx="table table-bordered table-striped table-hover rounded"
        :columns="columns"
        url="/transaksi/index"
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
        { name: "total", data: "total_harga" },
        { name: "nomor meja", data: "meja.no_meja" },
        { name: "Tipe pembayaran", data: "type_transaksi" },

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
      this.$refs.myTable.reload();
    },
    callback() {
      // Callback Example
      var app = this;
      $("#myTable").on("click", ".delete", function (e) {
        var id = $(this).data("id");

        window.snap.pay(id, {
          onSuccess: function (result) {
            /* You may add your own implementation here */
            axios
              .post("transaksi/done", { data: id })
              .then((res) => {
                app.$refs.myTable.reload();
                app.$router.push({ name: "home" });
                setTimeout(() => {
				Swal.fire({icon: 'success', title: 'yeyyyy..', text: 'pesananmu sedang diproses mohon tunggu sebentar'});
			},500)
              })
              .catch((err) => {});
          },
          onPending: function (result) {
            /* You may add your own implementation here */
            alert("wating your payment!");
            console.log(result);
          },
          onError: function (result) {
            /* You may add your own implementation here */
            alert("payment failed!");
            console.log(result);
          },
          onClose: function () {
            /* You may add your own implementation here */
            alert("you closed the popup without finishing the payment");
          },
        });
      });
    },
  },
};
</script>
