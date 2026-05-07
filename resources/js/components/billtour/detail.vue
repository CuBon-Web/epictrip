<template>
  <div>
    <h3 class="page-title">Chi tiết đơn hàng tour #{{ id }}</h3>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div v-if="!bill">
              Đang tải...
            </div>
            <div v-else>
              <h5>Thông tin khách hàng</h5>
              <p><strong>Tên:</strong> {{ bill.name }}</p>
              <p><strong>Điện thoại:</strong> {{ bill.phone }}</p>
              <p><strong>Email:</strong> {{ bill.email }}</p>
              <p><strong>Địa chỉ:</strong> {{ bill.address }}</p>
              <p><strong>Ghi chú:</strong> {{ bill.note }}</p>
              <p><strong>Người lớn:</strong> {{ bill.nguoilon }}</p>
              <p><strong>Trẻ em:</strong> {{ bill.treem }}</p>
              <p><strong>Tổng tiền:</strong> {{ formatMoney(bill.total) }}</p>
              <hr/>
              <h5>Tour</h5>
              <div v-if="tour">
                <p><strong>Tên tour:</strong> {{ tour.name }}</p>
                <p><strong>Giá:</strong> {{ formatMoney(tour.price) }}</p>
              </div>
              <div v-else>
                Không tìm thấy tour.
              </div>
              <hr/>
              <h5>Dịch vụ thêm</h5>
              <div v-if="services && services.length">
                <ul>
                  <li v-for="s in services" :key="s.id">
                    {{ s.name }} - {{ formatMoney(s.price) }}
                  </li>
                </ul>
              </div>
              <div v-else>Không có dịch vụ thêm</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  data: () => ({
    id: null,
    bill: null,
    tour: null,
    services: [],
  }),
  methods: {
    ...mapActions(["detailBillTour", "loadings"]),
    fetchDetail() {
      this.loadings && this.loadings(true);
      this.detailBillTour(this.id)
        .then((res) => {
          const data = res && res.data ? res.data : {};
          this.bill = data.bill || null;
          this.tour = data.tour || null;
          this.services = data.services || [];
        })
        .finally(() => {
          this.loadings && this.loadings(false);
        });
    },
    formatMoney(value) {
      if (value === null || value === undefined) return '';
      try {
        return new Intl.NumberFormat('vi-VN').format(Number(value));
      } catch (e) {
        return value;
      }
    },
  },
  mounted() {
    this.id = this.$route.params.id;
    this.fetchDetail();
  },
};
</script>

<style>
</style>

