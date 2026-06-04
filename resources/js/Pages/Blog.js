import axios from "axios";
import Swal from "sweetalert2";


export class Blog {
  constructor() {
    this.load();
  }

  load() {
    this.events();
    this.getData();
  }

  events() {
    let self = this;

    $("body").on("changer", ".list-cmb", function () {
      self.getData();
    })

    $("body").on("click", ".saveBlogBtn", function () {
      self.saveBlog();
    }).on("click", ".editBlogBtn", function () {
      const id = $(".selected").attr("data-id");
      if (id == undefined) {
        Swal.fire("Hata", "Lütfen bir blog/haber seçiniz", "error");
        return;

      }
      window.location.href = "/blog/edit/" + id;
    }).on("click", ".delBlogBtn", function () {
      let blog_id = $(this).attr('data_id');
      if (blog_id == undefined) {
        blog_id = $(".selected").attr("data-id");
        if (blog_id == undefined) {
          Swal.fire("Hata", "Lütfen bir blog/haber seçiniz", "error");
          return;
        }
      }
      self.delBlog(blog_id);
    }).on("click", ".toggleStatusBtn", function () {
      const blog_id = $(this).attr('data_id');
      const status = $(this).attr('data_status');
      self.toggleStatus(blog_id, status);
    }).on("change", "#filterStatus", function () {
      $("#blogTable").DataTable().ajax.reload();
    }).on("click", ".passiveBtn", function () {
      const blog_id = $(this).attr('data_id');
      self.passive(blog_id);
    }).on("click", ".activeBtn", function () {
      const blog_id = $(this).attr('data_id');
      self.active(blog_id);
    })





  }

  getData() {
    const table = $("#blogTable").DataTable({
      processing: true,
      serverSide: true,
      destroy: true,
      scrolly: "44vh",
      ajax: {
        url: "/api/blog/getData",
        type: "GET",
        data: function (d) {
          d.type = $(".type.cmb").val();
          d.status = $(".status-cmb").val();
        },
      },
      columns: [
        { data: "title", name: "title" },
        { data: "content", name: "content" },
        { data: "type_name", name: "type_name" },
        { data: "status_name", name: "status_name" },
        { data: "action", name: "action" }
      ],
      createdRow: function (row, data) {
        $(row).attr("data-id", data.id);
      }
    });

    $("#blogTable tbody").off("click", "tr").on("click", "tr", function () {
      if ($(this).hasClass("selected")) {
        $(this).removeClass("selected");
      } else {
        table.$("tr.selected").removeClass("selected");
        $(this).addClass("selected");
      }
    });
  }

  async saveBlog() {
    const blogdata = {
      title: $('.title').val(),
      description: $('.description').val(),
      content: $('#blogContent').val(),
      status: $('.status').val(),
      type_id: $('.type_id').val(),
      blog_id: $(".blog_id").val(),
    };

    console.log(blogdata);

    try {
      const { data } = await axios.post('/api/Blog/saveBlog', blogdata);

      if (data && data.status) {
        Swal.fire({ title: 'Bilgi', text: data.message, icon: 'success' }).then(() => {
          window.location.href = '/blog';
        })
      } else {
        Swal.fire('Hata', data.message || 'Bir hata oluştu', 'error');
      }

    } catch (error) {
      console.error(error);

      Swal.fire(
        'Hata',
        error.response?.data?.message || 'Sunucu hatası oluştu',
        'error'
      );
    }
  }

  async delBlog(blog_id) {
    const self = this
    const onay = await Swal.fire({
      title: "Emin misiniz?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Evet",
      cancelButtonText: "Hayır"
    });

    if (!onay.isConfirmed) return;
    const { data } = await axios.post('/api/Blog/delBlog', { blog_id: blog_id });

    if (data && data.status) {
      Swal.fire({ title: 'Bilgi', text: data.message, icon: 'success' }).then(() => {

      })
      self.getData();
    } else {
      Swal.fire('Hata', data.message || 'Bir hata oluştu', 'error');
    }

  }

  async toggleStatus(blog_id, status) {
    const self = this;
    try {
      const { data } = await axios.post('/api/Blog/toggleStatus', { blog_id: blog_id, status: status });

      if (data && data.status) {
        Swal.fire({ title: 'Bilgi', text: data.message, icon: 'success' }).then(() => {
          self.getData();
        });
      } else {
        Swal.fire('Hata', data.message || 'Bir hata oluştu', 'error');
      }

    } catch (error) {
      console.error(error);
      Swal.fire(
        'Hata',
        error.response?.data?.message || 'Sunucu hatası oluştu',
        'error'
      );
    }

  }
  async passive(id) {
    const self = this;
    try {
      const onay = await Swal.fire({
        title: "Emin misiniz?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Evet",
        cancelButtonText: "Hayır"
      });
      if (!onay.isConfirmed) return;

      const { data } = await axios.post('/api/blog/passive', { blog_id: id });
      if (data && data.status) {
        Swal.fire({ title: 'Bilgi', text: data.message, icon: 'success' }).then(() => {
          self.getData();
        })
      } else {
        Swal.fire('Hata', data.message || 'Bir hata oluştu', 'error');
      }

    } catch (error) {
      console.error(error);

      Swal.fire(
        'Hata',
        error.response?.data?.message || 'Sunucu hatası oluştu',
        'error'
      );
    }
  }

  async active(id) {
    const self = this;
    try {
      const onay = await Swal.fire({
        title: "Emin misiniz?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Evet",
        cancelButtonText: "Hayır"
      });
      if (!onay.isConfirmed) return;

      const { data } = await axios.post('/api/blog/active', { blog_id: id });
      if (data && data.status) {
        Swal.fire({ title: 'Bilgi', text: data.message, icon: 'success' }).then(() => {
          self.getData();
        })
      } else {
        Swal.fire('Hata', data.message || 'Bir hata oluştu', 'error');
      }

    } catch (error) {
      console.error(error);

      Swal.fire(
        'Hata',
        error.response?.data?.message || 'Sunucu hatası oluştu',
        'error'
      );
    }
  }
}

window.Blog = Blog;