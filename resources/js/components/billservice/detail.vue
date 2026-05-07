<template>
  <div>
    <h3 class="page-title">Chi tiết đơn dịch vụ #{{ id }}</h3>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div v-if="!booking">
              Đang tải...
            </div>
            <div v-else>
              <div class="alert alert-info" style="border-radius: 8px;">
                <h5 class="mb-2">Dịch vụ được đặt</h5>
                <p class="mb-1"><strong class="text-primary" style="font-size: 1.15rem;">{{ serviceName }}</strong></p>
                <p v-if="service" class="mb-1 text-muted small">Mã dịch vụ (CMS): #{{ service.id }} · Slug: {{ service.slug }}</p>
                <p v-if="servicePublicUrl" class="mb-0">
                  <a :href="servicePublicUrl" target="_blank" rel="noopener">Mở trang dịch vụ trên website</a>
                </p>
              </div>

              <h5 class="mt-4">Thông tin khách đặt</h5>
              <p><strong>Tên:</strong> {{ booking.name }}</p>
              <p><strong>Điện thoại:</strong> {{ booking.phone }}</p>
              <p><strong>Email:</strong> {{ booking.email || "—" }}</p>
              <p><strong>Ghi chú:</strong> {{ booking.note || "—" }}</p>
              <p><strong>Tổng (tạm):</strong> {{ formatMoney(booking.total) }}</p>
              <p><strong>Thời gian gửi:</strong> {{ booking.created_at }}</p>

              <hr v-if="service" />
              <div v-if="service">
                <h5>Thông tin dịch vụ (hệ thống)</h5>
                <p v-if="service.image"><img :src="service.image" alt="" style="max-width: 200px; border-radius: 6px;"></p>
                <p><strong>Giá (raw):</strong> {{ service.price }}</p>
                <p><strong>Trạng thái hiển thị:</strong> {{ service.status == 1 ? "Đang bật" : "Tắt" }}</p>
              </div>
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
    booking: null,
    service: null,
    serviceName: "",
    servicePublicUrl: null,
  }),
  methods: {
    ...mapActions(["detailServiceBooking", "loadings"]),
    fetchDetail() {
      this.loadings && this.loadings(true);
      this.detailServiceBooking(this.id)
        .then((res) => {
          const data = res && res.data ? res.data : {};
          this.booking = data.booking || null;
          this.service = data.service || null;
          this.serviceName = data.service_name || "";
          this.servicePublicUrl = data.service_public_url || null;
        })
        .finally(() => {
          this.loadings && this.loadings(false);
        });
    },
    formatMoney(value) {
      if (value === null || value === undefined) return "";
      try {
        return new Intl.NumberFormat("vi-VN").format(Number(value));
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
