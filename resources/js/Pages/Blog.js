import axios from "axios";
import Swal from "sweetalert2";


export class Blog {
  constructor() {
    this.load();
  }

  load() {
    this.events();
    this.getData();
    this.initTinyMCE();
  }

  initTinyMCE() {
    if ($('#blogContent').length > 0 && typeof tinymce !== 'undefined') {
      tinymce.init({
        selector: '#blogContent',
        plugins: [
          'accordion', 'advlist', 'anchor', 'autolink', 'autoresize', 'autosave', 
          'charmap', 'code', 'codesample', 'directionality', 'emoticons', 'fullscreen', 
          'help', 'image', 'importcss', 'insertdatetime', 'link', 'lists', 'media', 
          'nonbreaking', 'pagebreak', 'preview', 'quickbars', 'searchreplace', 
          'table', 'visualblocks', 'visualchars', 'wordcount'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | ' +
          'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist outdent indent | link image media table | ' +
          'forecolor backcolor emoticons | code fullscreen preview | help',
        language: 'tr',
        menubar: 'file edit view insert format tools table help',
        branding: false,
        promotion: false
      });
    }
  }

  events() {
    let self = this;

    $("body").on("change", ".list-cmb", function () {
      if ($("#blogTable").length > 0) {
        $("#blogTable").DataTable().ajax.reload();
      }
    })

    $("body").on("click", ".saveBlogBtn", function () {
      self.saveBlog();
    }).on("click", ".editBlogBtn", function () {
      const id = $(".selected").attr("data-id");
      if (id == undefined) {
        Swal.fire(window.translations.error || "Hata", window.translations.select_item || "Lütfen bir blog/haber seçiniz", "error");
        return;

      }
      window.location.href = "/blog/edit/" + id;
    }).on("click", ".delBlogBtn", function () {
      let blog_id = $(this).attr('data_id');
      if (blog_id == undefined) {
        blog_id = $(".selected").attr("data-id");
        if (blog_id == undefined) {
          Swal.fire(window.translations.error || "Hata", window.translations.select_item || "Lütfen bir blog/haber seçiniz", "error");
          return;
        }
      }
      self.delBlog(blog_id);
    }).on("click", ".toggleStatusBtn", function () {
      const blog_id = $(this).attr('data_id');
      const status = $(this).attr('data_status');
      self.toggleStatus(blog_id, status);
    }).on("click", ".passiveBtn", function () {
      const blog_id = $(this).attr('data_id');
      self.passive(blog_id);
    }).on("click", ".activeBtn", function () {
      const blog_id = $(this).attr('data_id');
      self.active(blog_id);
    })





  }

  getData() {
    if ($("#blogTable").length === 0) return;

    const table = $("#blogTable").DataTable({
      processing: true,
      serverSide: true,
      destroy: true,
      ajax: {
        url: "/api/blog/getData",
        type: "GET",
        data: function (d) {
          d.type = $(".type-cmb").val();
          d.status = $(".status-cmb").val();
        },
      },
      columns: [
        {
          data: "title",
          name: "title",
          render: function (data, type, row) {
            let iconClass = row.type_id == 1 ? 'bi-journal-richtext text-warning' : 'bi-newspaper text-primary';
            let iconBg = row.type_id == 1 ? 'bg-warning-light' : 'bg-primary-light';
            let cleanDesc = row.description ? row.description.replace(/<\/?[^>]+(>|$)/g, "") : '';
            return `
              <div class="d-flex align-items-center">
                <div class="avatar-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-3 ${iconBg}" style="width: 44px; height: 44px; min-width: 44px;">
                  <i class="bi ${iconClass} fs-4"></i>
                </div>
                <div class="text-truncate-container" style="max-width: 480px;">
                  <h6 class="mb-0.5 fw-bold text-dark" style="font-size: 0.95rem; margin-bottom: 3px;">${data}</h6>
                  <p class="mb-0 text-muted text-truncate" style="font-size: 0.825rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${cleanDesc}">${cleanDesc}</p>
                </div>
              </div>
            `;
          }
        },
        {
          data: "type_name",
          name: "type_name",
          render: function (data, type, row) {
            let badgeClass = row.type_id == 1 ? 'bg-soft-warning' : 'bg-soft-primary';
            let icon = row.type_id == 1 ? 'bi-journal-text' : 'bi-newspaper';
            return `<span class="badge ${badgeClass} px-3 py-2 rounded-pill fw-semibold d-inline-flex align-items-center gap-1" style="font-size: 0.75rem;"><i class="bi ${icon}"></i> ${data}</span>`;
          }
        },
        {
          data: "status_name",
          name: "status_name",
          render: function (data, type, row) {
            let isSuccess = row.status == 1;
            let dotColor = isSuccess ? '#10b981' : '#ef4444';
            let badgeBg = isSuccess ? 'bg-soft-success' : 'bg-soft-danger';
            return `
              <span class="badge ${badgeBg} px-3 py-2 rounded-pill fw-semibold d-inline-flex align-items-center gap-1.5" style="font-size: 0.75rem;">
                <span class="status-dot" style="width: 8px; height: 8px; background-color: ${dotColor}; border-radius: 50%; display: inline-block;"></span>
                ${data}
              </span>
            `;
          }
        },
        {
          data: "action",
          name: "action",
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            let editUrl = `/blog/edit/${row.id}`;
            let passiveText = window.translations.make_passive || 'Pasif Yap';
            let activeText = window.translations.make_active || 'Aktif Yap';
            let editText = window.translations.edit || 'Düzenle';
            let deleteText = window.translations.delete || 'Sil';
            
            let statusBtn = row.status == 1 
              ? `<button type="button" class="btn btn-action btn-outline-warning passiveBtn" data_id="${row.id}" title="${passiveText}"><i class="bi bi-eye-slash"></i></button>`
              : `<button type="button" class="btn btn-action btn-outline-success activeBtn" data_id="${row.id}" title="${activeText}"><i class="bi bi-eye"></i></button>`;
            
            return `
              <div class="d-flex align-items-center justify-content-end gap-1.5">
                <a href="${editUrl}" class="btn btn-action btn-outline-primary" title="${editText}">
                  <i class="bi bi-pencil-square"></i>
                </a>
                ${statusBtn}
                <button type="button" class="btn btn-action btn-outline-danger delBlogBtn" data_id="${row.id}" title="${deleteText}">
                  <i class="bi bi-trash3"></i>
                </button>
              </div>
            `;
          }
        }
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
    if (typeof tinymce !== 'undefined') {
      tinymce.triggerSave();
    }

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
        Swal.fire({ title: window.translations.success || 'Bilgi', text: data.message, icon: 'success' }).then(() => {
          window.location.href = '/blog';
        })
      } else {
        Swal.fire(window.translations.error || 'Hata', data.message || 'Bir hata oluştu', 'error');
      }

    } catch (error) {
      console.error(error);

      Swal.fire(
        window.translations.error || 'Hata',
        error.response?.data?.message || 'Sunucu hatası oluştu',
        'error'
      );
    }
  }

  async delBlog(blog_id) {
    const self = this
    const onay = await Swal.fire({
      title: window.translations.are_you_sure || "Emin misiniz?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: window.translations.yes || "Evet",
      cancelButtonText: window.translations.no || "Hayır"
    });

    if (!onay.isConfirmed) return;
    const { data } = await axios.post('/api/Blog/delBlog', { blog_id: blog_id });

    if (data && data.status) {
      Swal.fire({ title: window.translations.success || 'Bilgi', text: data.message, icon: 'success' }).then(() => {

      })
      self.getData();
    } else {
      Swal.fire(window.translations.error || 'Hata', data.message || 'Bir hata oluştu', 'error');
    }

  }

  async toggleStatus(blog_id, status) {
    const self = this;
    try {
      const { data } = await axios.post('/api/Blog/toggleStatus', { blog_id: blog_id, status: status });

      if (data && data.status) {
        Swal.fire({ title: window.translations.success || 'Bilgi', text: data.message, icon: 'success' }).then(() => {
          self.getData();
        });
      } else {
        Swal.fire(window.translations.error || 'Hata', data.message || 'Bir hata oluştu', 'error');
      }

    } catch (error) {
      console.error(error);
      Swal.fire(
        window.translations.error || 'Hata',
        error.response?.data?.message || 'Sunucu hatası oluştu',
        'error'
      );
    }

  }
  async passive(id) {
    const self = this;
    try {
      const onay = await Swal.fire({
        title: window.translations.are_you_sure || "Emin misiniz?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: window.translations.yes || "Evet",
        cancelButtonText: window.translations.no || "Hayır"
      });
      if (!onay.isConfirmed) return;

      const { data } = await axios.post('/api/blog/passive', { blog_id: id });
      if (data && data.status) {
        Swal.fire({ title: window.translations.success || 'Bilgi', text: data.message, icon: 'success' }).then(() => {
          self.getData();
        })
      } else {
        Swal.fire(window.translations.error || 'Hata', data.message || 'Bir hata oluştu', 'error');
      }

    } catch (error) {
      console.error(error);

      Swal.fire(
        window.translations.error || 'Hata',
        error.response?.data?.message || 'Sunucu hatası oluştu',
        'error'
      );
    }
  }

  async active(id) {
    const self = this;
    try {
      const onay = await Swal.fire({
        title: window.translations.are_you_sure || "Emin misiniz?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: window.translations.yes || "Evet",
        cancelButtonText: window.translations.no || "Hayır"
      });
      if (!onay.isConfirmed) return;

      const { data } = await axios.post('/api/blog/active', { blog_id: id });
      if (data && data.status) {
        Swal.fire({ title: window.translations.success || 'Bilgi', text: data.message, icon: 'success' }).then(() => {
          self.getData();
        })
      } else {
        Swal.fire(window.translations.error || 'Hata', data.message || 'Bir hata oluştu', 'error');
      }

    } catch (error) {
      console.error(error);

      Swal.fire(
        window.translations.error || 'Hata',
        error.response?.data?.message || 'Sunucu hatası oluştu',
        'error'
      );
    }
  }

  async getBlogData() {
    const { data } = await axios.post("/api/blogs/getBlogData", {
      blog_id: $(".blog_id").val(),
      lang_code: $(".lang").val(),
    });

    if (data && data.status) {
      if (data.data != null) {
        $(".title").val(data.data.title);
        $(".description").val(data.data.description);
        $(".type").val(data.data.type_id);
        $(".status").val(data.data.status);
        $(".content_text").val(data.data.content);
      } else {
        $(".title").val("");
        $(".description").val("");
        $(".type").val(1);
        $(".status").val(1);
        $(".content_text").val("");
      }
    }
  }


}

window.Blog = Blog;