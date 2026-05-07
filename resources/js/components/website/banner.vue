<template>
  <div>
    <h3 class="page-title">Quản lý banner</h3>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div
              class="banner-item"
              v-for="(item, key) in objData"
              :key="`banner-${key}`"
            >
              <div class="banner-item__head">
                <h5>Banner {{ key + 1 }}</h5>
                <button
                  v-if="objData.length > 1"
                  type="button"
                  class="banner-remove"
                  title="Xóa banner"
                  @click="removeObjBanner(key)"
                >
                  <vs-icon icon="clear"></vs-icon>
                </button>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Loại media</label>
                    <vs-select
                      v-model="item.media_type"
                      class="w-100"
                      @input="handleMediaTypeChange(item)"
                    >
                      <vs-select-item value="image" text="Ảnh" />
                      <vs-select-item value="video" text="Video file / URL" />
                      <vs-select-item value="youtube" text="Video YouTube" />
                    </vs-select>
                  </div>

                  <div class="form-group" v-if="item.media_type === 'image'">
                    <label>Ảnh banner</label>
                    <image-upload
                      type="avatar"
                      v-model="item.image"
                      :title="'banner-trang-chu'"
                    ></image-upload>
                  </div>

                  <div class="form-group" v-else>
                    <label>{{ item.media_type === 'youtube' ? 'Link YouTube' : 'Link video' }}</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="item.image"
                      :placeholder="item.media_type === 'youtube'
                        ? 'https://www.youtube.com/watch?v=...'
                        : 'https://domain.com/video.mp4'"
                    >
                    <small class="text-muted" v-if="item.media_type === 'youtube'">
                      Hỗ trợ youtube.com/watch, youtu.be, shorts, embed, live.
                    </small>
                    <small class="text-muted" v-else>
                      Hỗ trợ mp4, webm, mov, ogg, m4v.
                    </small>
                  </div>

                  <div class="banner-preview" v-if="item.image">
                    <img
                      v-if="item.media_type === 'image'"
                      :src="item.image"
                      alt="Banner preview"
                    >
                    <video
                      v-else-if="item.media_type === 'video'"
                      :src="item.image"
                      controls
                      muted
                      playsinline
                    ></video>
                    <iframe
                      v-else-if="getYoutubeEmbed(item.image)"
                      :src="getYoutubeEmbed(item.image)"
                      title="YouTube preview"
                      frameborder="0"
                      allow="autoplay; encrypted-media; picture-in-picture"
                      allowfullscreen
                    ></iframe>
                    <div v-else class="banner-preview__empty">
                      Link YouTube chưa đúng định dạng.
                    </div>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                    <multi-lang-field
                      v-model="item.title"
                      :languages="lang"
                      type="text"
                      label="Tiêu đề"
                      placeholder="Tiêu đề banner"
                    />
                  </div>

                  <div class="form-group">
                    <multi-lang-field
                      v-model="item.subtitle"
                      :languages="lang"
                      type="text"
                      label="Subtitle"
                      placeholder="Subtitle banner"
                    />
                  </div>

                  <div class="form-group">
                    <multi-lang-field
                      v-model="item.description"
                      :languages="lang"
                      type="textarea"
                      label="Mô tả"
                      placeholder="Mô tả banner"
                    />
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label>Link button</label>
                        <vs-input
                          type="text"
                          v-model="item.link"
                          size="default"
                          placeholder="Link khi bấm nút trong banner"
                          class="w-100"
                        />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Trạng thái</label>
                        <vs-select v-model="item.status" class="w-100">
                          <vs-select-item value="1" text="Hiện" />
                          <vs-select-item value="0" text="Ẩn" />
                        </vs-select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="banner-actions">
              <vs-button color="primary" @click="saveBanners">Lưu</vs-button>
              <vs-button color="success" @click="addObjBanner">Thêm banner</vs-button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "banner",
  data() {
    return {
      lang: [],
      objData: [this.createBanner()]
    };
  },
  methods: {
    ...mapActions(["saveBanner", "loadings", "listBanner", "listLanguage"]),
    createTranslatable(value = "") {
      const langs = this.lang && this.lang.length
        ? this.lang
        : [{ code: "en-US" }, { code: "es-ES" }];

      return langs.map((item, index) => ({
        lang_code: item.code || item.lang_code || (index === 0 ? "en-US" : "es-ES"),
        content: index === 0 ? value : ""
      }));
    },
    parseTranslatable(value) {
      if (Array.isArray(value)) {
        return this.fillMissingLanguages(value);
      }

      if (typeof value === "string" && value !== "") {
        try {
          const parsed = JSON.parse(value);
          if (Array.isArray(parsed)) {
            return this.fillMissingLanguages(parsed);
          }
        } catch (e) {
          return this.createTranslatable(value);
        }
      }

      return this.createTranslatable("");
    },
    fillMissingLanguages(value) {
      const normalized = value.map(item => ({
        lang_code: item.lang_code || item.code || "en-US",
        content: item.content || ""
      }));

      (this.lang || []).forEach(langItem => {
        const code = langItem.code || langItem.lang_code;
        if (code && !normalized.some(item => item.lang_code === code)) {
          normalized.push({ lang_code: code, content: "" });
        }
      });

      return normalized.length ? normalized : this.createTranslatable("");
    },
    createBanner(data = {}) {
      const image = data.image || "";
      return {
        image,
        media_type: data.media_type || this.detectMediaType(image),
        status: String(data.status != null ? data.status : 1),
        link: data.link || "",
        title: this.parseTranslatable(data.title || ""),
        description: this.parseTranslatable(data.description || ""),
        subtitle: this.parseTranslatable(data.subtitle || "")
      };
    },
    isVideoFileUrl(url) {
      if (!url) return false;
      const cleanUrl = String(url).split("?")[0].split("#")[0].toLowerCase();
      return /\.(mp4|webm|mov|ogg|m4v)$/.test(cleanUrl);
    },
    detectMediaType(url) {
      if (!url) return "image";
      if (this.getYoutubeId(url)) return "youtube";
      if (this.isVideoFileUrl(url)) return "video";
      return "image";
    },
    getYoutubeId(url) {
      if (!url) return "";
      const match = String(url).match(/(?:youtu\.be\/|youtube(?:-nocookie)?\.com\/(?:watch\?v=|embed\/|shorts\/|v\/|live\/))([A-Za-z0-9_-]{11})/i);
      return match ? match[1] : "";
    },
    getYoutubeEmbed(url) {
      const id = this.getYoutubeId(url);
      if (!id) return "";
      return `https://www.youtube-nocookie.com/embed/${id}?autoplay=0&rel=0&modestbranding=1`;
    },
    handleMediaTypeChange(item) {
      if (!item.image) return;
      const isYt = !!this.getYoutubeId(item.image);
      const isVideoFile = this.isVideoFileUrl(item.image);

      if (item.media_type === "youtube" && !isYt) item.image = "";
      else if (item.media_type === "video" && (isYt || !isVideoFile)) item.image = "";
      else if (item.media_type === "image" && (isYt || isVideoFile)) item.image = "";
    },
    normalizePayload() {
      return this.objData.map(item => ({
        image: item.image || "",
        status: parseInt(item.status, 10),
        link: item.link || "",
        title: this.fillMissingLanguages(item.title || []),
        subtitle: this.fillMissingLanguages(item.subtitle || []),
        description: this.fillMissingLanguages(item.description || [])
      }));
    },
    validateBanners() {
      const errors = [];
      this.objData.forEach((item, index) => {
        if (!item.image) {
          errors.push(`Banner ${index + 1}: vui lòng nhập/chọn media.`);
        }
        if (item.media_type === "youtube" && !this.getYoutubeId(item.image)) {
          errors.push(`Banner ${index + 1}: link YouTube không hợp lệ.`);
        }
      });
      return errors;
    },
    saveBanners() {
      const errors = this.validateBanners();
      if (errors.length) {
        errors.forEach(error => this.$error(error));
        return;
      }

      this.loadings(true);
      this.saveBanner({ data: this.normalizePayload() }).then(response => {
        this.loadings(false);
        this.$success("Sửa banner thành công");
        this.listBanners();
      }).catch(error => {
        this.loadings(false);
        this.$error("Sửa banner thất bại");
      });
    },
    addObjBanner() {
      this.objData.push(this.createBanner());
    },
    removeObjBanner(i) {
      this.objData.splice(i, 1);
    },
    listLang() {
      return this.listLanguage().then(response => {
        this.lang = response.data || [];
      });
    },
    listBanners() {
      this.loadings(true);
      this.listBanner().then(response => {
        const data = response.data || [];
        this.objData = data.length
          ? data.map(item => this.createBanner(item))
          : [this.createBanner()];
        this.loadings(false);
      }).catch(error => {
        this.loadings(false);
      });
    }
  },
  mounted() {
    this.loadings(true);
    this.listLang()
      .catch(() => {})
      .then(() => this.listBanners());
  }
};
</script>

<style scoped>
.banner-item {
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 18px;
  margin-bottom: 20px;
  background: #fff;
}

.banner-item__head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.banner-item__head h5 {
  margin: 0;
  font-weight: 700;
}

.banner-remove {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border: 0;
  border-radius: 50%;
  background: #fee2e2;
  color: #dc2626;
  cursor: pointer;
}

.banner-preview {
  position: relative;
  width: 100%;
  min-height: 180px;
  border-radius: 10px;
  overflow: hidden;
  background: #111827;
  border: 1px solid #e5e7eb;
}

.banner-preview img,
.banner-preview video,
.banner-preview iframe {
  width: 100%;
  height: 180px;
  object-fit: cover;
  display: block;
}

.banner-preview__empty {
  min-height: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  text-align: center;
  padding: 16px;
}

.banner-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}
</style>