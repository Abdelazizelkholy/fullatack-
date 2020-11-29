<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
          <p class="_title0"> Tags
            <Button @click="addModel=true">
              <Icon type="md-add"/>
              Add New Tag
            </Button>
          </p>

          <div class="_overflow _table_div">
            <table class="_table">
              <!-- TABLE TITLE -->
              <tr>
                <th>ID</th>
                <th>Tag Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->


              <!-- ITEMS -->
              <tr v-for="(tag, i) in tags">
                <td>{{ tag.id }}</td>
                <td class="_table_name">{{ tag.tagName }}</td>
                <td>{{ tag.created_at }}</td>
                <td>
                  <Button type="info" size="small" @click="showEditModel(tag, i)">Edit</Button>
                  <Button type="error" size="small" @click="showDeletingModel(tag, i)" :loading="tag.isDeleting">Delete
                  </Button>

                </td>
              </tr>


            </table>
          </div>
        </div>
        <!--~~~~~~~  tag add model   ~~~~~~~~~-->
        <Modal
            v-model=addModel
            title=" Add New Tag "
            :mask-closable="false"
            :closable="false"
        >
          <Input v-model="data.tagName" placeholder="Edit tag name"/>
          <div slot="footer">
            <Button type="primary" @click="addTag" :disable="isAdding" :loading="isAdding">
              {{ isAdding ? 'Adding' : 'Add New Tag' }}
            </Button>
            <Button type="default" @click="addModel=false">Close</Button>
          </div>
        </Modal>
        <!--~~~~~~~  tag edit model   ~~~~~~~~~-->
        <Modal
            v-model=editModel
            title=" Edit Tag "
            :mask-closable="false"
            :closable="false"
        >
          <Input v-model="editData.tagName" placeholder="add  tag name"/>
          <div slot="footer">
            <Button type="primary" @click="editTag" :disable="isAdding" :loading="isAdding">
              {{ isAdding ? 'Editing' : 'Edit Tag' }}
            </Button>
            <Button type="default" @click="editModel=false">Close</Button>
          </div>
        </Modal>
        <!--~~~~~~~  tag delete model   ~~~~~~~~~-->
        <Modal v-model="showDeleteModel" width="360">
          <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
          </p>
          <div style="text-align:center">
            <p>Are you sure you want to delete tag?.</p>
          </div>
          <div slot="footer">
            <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting"
                    @click="deleteTag">
              Delete
            </Button>
          </div>
        </Modal>
      </div>
    </div>
  </div>
</template>
<script>
export default {

  data() {
    return {
      data: {
        tagName: '',
      },
      editData: {
        tagName: '',
      },
      addModel: false,
      editModel: false,
      showDeleteModel: false,
      isAdding: false,
      isDeleting: false,
      tags: [],
      index: -1,
      deleteItem: {},
      deletingIndex: -1,
    }
  },
  methods: {
    async addTag() {
      if (this.data.tagName.trim() == '') return this.e('tag name is required !')
      const res = await this.callApi('post', 'app/create_tag', this.data)
      if (res.status === 201) {
        this.tags.unshift(res.data)
        this.s('tag has been added successfully !')
        this.addModel = false
        this.data.tagName = ''
      } else {
        if (res.status === 422) {
          if (res.data.errors.tagName) {
            this.i(res.data.errors.tagName[0])
          }
        } else {
          this.swr()
        }

      }
    },
    async editTag() {
      if (this.editData.tagName.trim() == '') return this.e('tag name is required !')
      const res = await this.callApi('post', 'app/edit_tag', this.editData)
      if (res.status === 200) {
        this.tags[this.index].tagName = this.editData.tagName
        this.s('tag has been updated successfully !')
        this.editModel = false
        this.tagName = ''
      } else {
        if (res.status === 422) {
          if (res.data.errors.tagName) {
            this.i(res.data.errors.tagName[0])
          }
        } else {
          this.swr()
        }

      }
    },
    showEditModel(tag, index) {
      let obj = {
        id: tag.id,
        tagName: tag.tagName
      }
      this.editData = obj
      this.editModel = true
      this.index = index
    },
    async deleteTag() {
      this.isDeleting = true
      const res = await this.callApi('post', 'app/delete_tag', this.deleteItem)
      if (res.status === 200) {
        this.tags.splice(this.deletingIndex, 1)
        this.s('tag has been deleted successfully ')
      } else {
        this.swr()
      }
      this.isDeleting = false
      this.showDeleteModel = false
    },
    showDeletingModel(tag, i) {
      this.deleteItem = tag
      this.deletingIndex = i
      this.showDeleteModel = true
    }
  },
  async created() {
    const res = await this.callApi('get', 'app/get_tags')
    if (res.status === 200) {
      this.tags = res.data
    } else {
      this.swr()
    }
  },
}
</script>
