<template>
  <!-- partial -->
  <div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Danh mục thẻ tag</h4>
              <router-link class="nav-link" :to="{name:'add_tag_cate'}">
                <vs-button type="gradient" style="float:right;">Thêm mới</vs-button>
              </router-link>
              <p v-if="canReorder" class="drag-hint">Kéo thả hàng để thay đổi thứ tự hiển thị</p>
              <vs-input
                icon="search"
                placeholder="Search"
                v-model="keyword"
                @keyup="searchCategory()"
              />
              <div class="con-tablex vs-table--not-data">
                <table class="vs-table vs-table--tbody-table tag-cate-table">
                  <thead>
                    <tr>
                      <th v-if="canReorder" class="drag-col"></th>
                      <th>ID</th>
                      <th>Tên</th>
                      <th>Trạng thái menu</th>
                      <th>Trạng thái bộ lọc</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(tr, indextr) in list"
                      :key="tr.id"
                      :class="{
                        'drag-row': canReorder,
                        'drag-over': dragOverIndex === indextr,
                        'dragging': dragFromIndex === indextr
                      }"
                      @dragenter.prevent="onDragOver(indextr)"
                      @dragover.prevent="onDragOver(indextr)"
                      @dragleave="onDragLeave(indextr)"
                      @drop.prevent.stop="onDrop(indextr, $event)"
                    >
                      <td
                        v-if="canReorder"
                        class="drag-handle"
                        :draggable="canReorder"
                        @dragstart.stop="onDragStart(indextr, $event)"
                        @dragend.stop="onDragEnd"
                      >
                        <i class="material-icons">drag_indicator</i>
                      </td>
                      <td>{{ tr.id }}</td>
                      <td>{{ languageName(tr.name) }}</td>
                      <td>{{ tr.status == 1 ? 'Hiện' : 'Ẩn' }}</td>
                      <td>{{ tr.status_filter == 1 ? 'Hiện' : 'Ẩn' }}</td>
                      <td class="action-cell" @dragstart.stop>
                        <router-link :to="{name:'edit_tag_cate',params:{id:tr.id}}">
                          <vs-button
                            vs-type="gradient"
                            size="lagre"
                            color="success"
                            icon="edit"
                          ></vs-button>
                        </router-link>
                        <vs-button
                          vs-type="gradient"
                          size="lagre"
                          color="red"
                          icon="delete_forever"
                          @click="confirmDestroy(tr.id)"
                        ></vs-button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <vs-popup style="width:100%;" title="Thêm mới thương hiệu" :active.sync="popupActivo">
        <ModalAdd @closePopup="closePop($event)" />
      </vs-popup>
  </div>
</template>


<script>
import ModalAdd from "../../components/layouts/modal/typeCate/add";
import { mapActions } from "vuex";
export default {
  data: () => ({
    keyword: null,
    popupActivo: false,
    list: [],
    timer:0,
    id_item :'',
    dragFromIndex: null,
    dragOverIndex: null
  }),
  components: {
    ModalAdd
  },
  computed: {
    canReorder() {
      return !(this.keyword && String(this.keyword).trim());
    }
  },
  methods: {
    ...mapActions(["listTagCate","destroyTagCate", "sortTagCate", "loadings"]),
    closePop(event) {
      this.listTypeCategory();
      this.popupActivo = event;
    },
    listTagCates() {
      this.loadings(true);
      this.listTagCate({ keyword: this.keyword })
      .then(response => {
          this.loadings(false);
          this.list = this.prepareSortOrder(response.data);
        });
    },
    prepareSortOrder(data) {
      return (data || []).map((item, index) => ({
        ...item,
        sort_order: item.sort_order && parseInt(item.sort_order) > 0 ? parseInt(item.sort_order) : index + 1
      }));
    },
    onDragStart(index, event) {
      if (!this.canReorder) return;
      this.dragFromIndex = index;
      event.dataTransfer.effectAllowed = "move";
      event.dataTransfer.setData("text/plain", String(index));
    },
    onDragOver(index) {
      if (this.dragFromIndex === null || !this.canReorder) return;
      this.dragOverIndex = index;
    },
    onDragLeave(index) {
      if (this.dragOverIndex === index) {
        this.dragOverIndex = null;
      }
    },
    onDrop(dropIndex, event) {
      const fromData =
        event && event.dataTransfer
          ? event.dataTransfer.getData("text/plain")
          : "";
      const fromIndex =
        fromData !== ""
          ? parseInt(fromData, 10)
          : this.dragFromIndex;
      if (
        !this.canReorder ||
        fromIndex === null ||
        Number.isNaN(fromIndex) ||
        fromIndex === dropIndex
      ) {
        return;
      }
      const next = [...this.list];
      const dragged = next.splice(fromIndex, 1)[0];
      next.splice(dropIndex, 0, dragged);
      this.list = next.map((item, idx) => ({
        ...item,
        sort_order: idx + 1
      }));
      this.dragFromIndex = null;
      this.dragOverIndex = null;
      this.saveSortOrder();
    },
    onDragEnd() {
      this.dragOverIndex = null;
      this.dragFromIndex = null;
    },
    saveSortOrder() {
      this.loadings(true);
      this.sortTagCate({
        categories: this.list.map((item, index) => ({
          id: item.id,
          sort_order: index + 1
        }))
      })
        .then(() => {
          this.loadings(false);
          this.$success("Cập nhật thứ tự thành công");
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Cập nhật thứ tự thất bại");
          this.listTagCates();
        });
    },
    searchCategory() {
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      this.timer = setTimeout(() => {
          this.listTagCate({ keyword: this.keyword })
          .then(response => {
            this.list = this.prepareSortOrder(response.data);
          });
      }, 800);
    },
    destroy(){
      this.loadings(true);
      this.destroyTagCate(this.id_item)
      .then(response => {
        this.listTagCates()
        this.loadings(false);
        this.$success('Xóa danh mục thành công');
      });
    },
    confirmDestroy(id){
      this.id_item = id;
      this.$vs.dialog({
        type:'confirm',
        color: 'danger',
        title: `Bạn có chắc chắn`,
        text: 'Xóa danh mục này',
        accept:this.destroy
      })
    },
    languageName(value) {
      if (Array.isArray(value)) {
        const first = value.find(item => (item.content || "").trim() !== "");
        return first ? first.content : "";
      }
      try {
        const parsed = JSON.parse(value);
        if (Array.isArray(parsed)) {
          const first = parsed.find(item => (item.content || "").trim() !== "");
          return first ? first.content : "";
        }
      } catch (e) {}
      return value || "";
    }
  },
  mounted() {
    this.listTagCates()
  }
};
</script>
<style>
.drag-hint {
  margin: 0 0 10px;
  color: #6b7280;
  font-size: 13px;
}

.drag-row {
  cursor: grab;
}

.drag-row.dragging {
  opacity: 0.5;
  cursor: grabbing;
}

.drag-row.drag-over td {
  border-top: 2px solid #7367f0;
}

.drag-handle {
  width: 40px;
  text-align: center;
  color: #9ca3af;
  user-select: none;
}

.drag-handle .material-icons {
  font-size: 22px;
  vertical-align: middle;
}

.tag-cate-table {
  width: 100%;
}

.tag-cate-table th,
.tag-cate-table td {
  padding: 10px 12px;
  vertical-align: middle;
}

.tag-cate-table thead th {
  font-weight: 600;
}

.action-cell {
  white-space: nowrap;
}
</style>
