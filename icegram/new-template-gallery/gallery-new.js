var Gallery = {
  showOverlay: false,
  currentImage: "",
  currentDesc: "",
  currentSlug: "",
  currentId: "",
  currentPlan: "",
  categories: [],
  projects: [],
  allProjects: [],
  filteredProjects: [],
  isLoading: true,
  error: null,
  currentPage: 1,
  itemsPerPage: 8,
  searchQuery: "",
  totalItems: 0,
  observer: null,
  lastProjectRef: null,
  showCategoryFilter: true,
  hasInteracted: false,
  selectedCategory: null,
  currentFilter: "all",
  allProjectsLoaded: false,
  showRevealedOffer: false,
  showDiscountNotice: true,
  isClosingNotice: false,

  oninit: function() {
    // Check if discount notice was already dismissed or unlocked in DB
    if (_wpThemeSettings && _wpThemeSettings.settings && 
        (_wpThemeSettings.settings.discount_notice_dismissed === 'yes' || 
         _wpThemeSettings.settings.unlock_discount_notice === 'yes')) {
      this.showDiscountNotice = false;
    }
    this.loadCategories();
    this.loadAllProjects(); // Load all projects first for category counts
  },

  oncreate: function() {
    // Initialize Intersection Observer for lazy loading
    var self = this;
    this.observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting && !self.isLoading && self.currentPage * self.itemsPerPage < self.totalItems) {
          self.loadMoreProjects();
        }
      });
    }, { threshold: 0.1 });
  },

  loadCategories: function() { 
    var self = this;
    m.request({
      method: "GET",
      url: _wpThemeSettings && _wpThemeSettings.settings && _wpThemeSettings.settings.ig_cat_api_url,
      deserialize: function(data) { return data; }
    }).then(function(result) {
      self.categories = result.filter(function(cat) {
        return parseInt(cat.is_visible_in_gallery) === 1; // only include if flag is set
      });
    }).catch(function(e) {
      self.error = "Failed to load categories. Please try again later.";
      console.error("Category load error:", e);
    });
  },

  loadAllProjects: function() {
    var self = this;
    m.request({
      method: "GET",
      url: _wpThemeSettings && _wpThemeSettings.settings && _wpThemeSettings.settings.ig_projects_api_url,
      params: {
        page: 1,
        per_page: 100 // Get enough to populate category counts
      }
    }).then(function(result) {
      var items = result.items || result;
      self.allProjects = items;
      self.allProjectsLoaded = true;
      console.log("Loaded all projects:", items.length);
      
      // Debug: Check first project's categories
      if (items.length > 0 && items[0].custom_category) {
        console.log("Sample project categories:", items[0].custom_category, "Type:", typeof items[0].custom_category);
      }
      
      m.redraw(); // Force redraw to update counts
    }).catch(function(e) {
      console.error("Failed to load all projects:", e);
    });
  },

  loadProjects: function(filter) {
    if (typeof filter === 'undefined') {
      filter = this.currentFilter;
    }
    this.isLoading = true;
    this.error = null;

    // Build dynamic params
    var params = {
      page: this.currentPage,
      per_page: this.itemsPerPage,
    };

    if (filter && filter !== "all") {
      params.custom_category = filter;
    }

    if (this.searchQuery && this.searchQuery.trim() !== "") {
      params.search = this.searchQuery.trim();
    }
    
    console.log("Loading projects with params:", params);
    
    var self = this;
    m.request({
      method: "GET",
      url: _wpThemeSettings && _wpThemeSettings.settings && _wpThemeSettings.settings.ig_projects_api_url,
      params: params,
    }).then(function(result) {
      console.log("API Response:", result);
      
      var items = result.items || result;
      var total = result.total || items.length;
      
      if (self.currentPage === 1) {
        self.projects = items;
        self.filteredProjects = items;
      } else {
        self.projects = [].concat(self.projects, items);
        self.filteredProjects = [].concat(self.filteredProjects, items);
      }
      self.totalItems = total;
      self.isLoading = false;
    }).catch(function(e) {
      self.error = "Failed to load projects. Please try again later.";
      self.isLoading = false;
      console.error("Project load error:", e);
    });
  },

  
  loadMoreProjects: function() {
    this.currentPage++;
    this.loadProjects(this.currentFilter);
  },

  handleSearch: function(e) {
    this.searchQuery = e.target.value;
    this.currentPage = 1;

    if (this.searchQuery.trim() !== "") {
      this.hasInteracted = true;
      this.showCategoryFilter = false;
      this.loadProjects(this.currentFilter);
      window.scrollTo({ top: 0, behavior: "smooth" });
    } else {
      this.hasInteracted = false;
      this.filteredProjects = [];
      this.projects = [];
      this.showCategoryFilter = true;
    }
  },

  handleFilterChange: function(filter) {
    this.hasInteracted = true;
    this.currentFilter = filter;
    this.currentPage = 1;
    this.showCategoryFilter = false;
    this.loadProjects(filter);
    this.selectedCategory = this.categories.find(function(cat) { return cat.id === filter; }) || null;
    window.scrollTo({ top: 0, behavior: "smooth" });
  },

  showAllCategories: function() {
    this.currentFilter = "all";
    this.showCategoryFilter = true;
    this.filteredProjects = [];
    this.projects = [];
    this.hasInteracted = false;
    this.searchQuery = "";
  },

  dismissDiscountNotice: function() {
    var self = this;
    
    // Trigger fade-out animation
    self.isClosingNotice = true;
    
    // Make AJAX call to dismiss the notice
    if (_wpThemeSettings && _wpThemeSettings.settings && _wpThemeSettings.settings.ajax_url) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', _wpThemeSettings.settings.ajax_url, true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      
      xhr.onload = function() {
        if (xhr.status === 200) {
          console.log('Discount notice dismissed successfully');
        }
      };
      
      xhr.onerror = function() {
        console.error('Failed to dismiss discount notice');
      };
      
      var params = 'action=ig_dismiss_discount_notice&security=' + 
                   encodeURIComponent(_wpThemeSettings.settings.dismiss_discount_nonce);
      xhr.send(params);
    }
    
    // Hide the notice after animation completes
    setTimeout(function() {
      self.showDiscountNotice = false;
      self.isClosingNotice = false;
      m.redraw();
    }, 400); // Match the animation duration
  },
  
  view: function () {
    var igPlan = parseInt((_wpThemeSettings && _wpThemeSettings.settings && _wpThemeSettings.settings.ig_plan) || "0");
    
    return m(".font-nunito.min-h-screen", [
      // Discount Notice Banner - Initial Offer (Only for Lite version - ig_plan = 0)
      !this.showRevealedOffer && this.showDiscountNotice && igPlan === 0 && m(".relative.overflow-hidden.mb-8.rounded-lg.max-w-6xl.mx-auto.px-12.mt-4.shadow-xl" + (this.isClosingNotice ? ".animate-fadeOut" : ".animate-slideDown"), {
        style: {
          background: "linear-gradient(135deg, #4f46e5 0%, #6366f1 33%, #8b5cf6 66%, #a855f7 100%)"
        }
      }, [
        // Close button
        m("button.absolute.text-white.text-3xl.font-bold.w-10.h-10.flex.items-center.justify-center.rounded-full.focus:outline-none", {
          type: "button",
          style: { top: "0.5rem", right: "0.5rem" },
          onclick: function(e) {
            e.stopPropagation();
            Gallery.dismissDiscountNotice();
          },
          title: "Close"
        }, "×"),
        m(".relative.z-10.py-6.px-8.text-center", [
          m(".flex.flex-col.md:flex-row.items-center.justify-center.gap-4", [
            m(".flex.items-center.gap-3", [
              m("img.gentle-bounce", { 
                src: _wpThemeSettings && _wpThemeSettings.settings && _wpThemeSettings.settings.ig_img_path + "discount-gift.png",
                alt: "Special Offer",
                style: { 
                  width: "80px",
                  height: "80px",
                  border: "0"
                }
              }),
              m("h3.text-white.text-xl.md:text-2xl.font-bold.leading-tight", [
                "You've unlocked a special discount on Icegram Engage. ",
                m("br.hidden.md:block"),
                "Reveal your offer and save on your upgrade."
              ])
            ]),
            m("button.bg-white.text-purple-700.font-bold.text-lg.py-3.px-8.rounded-full.shadow-lg.hover:shadow-2xl.transform.hover:scale-105.transition-all.duration-300.focus:outline-none", {
              type: "button",
              onclick: function() {
                Gallery.showRevealedOffer = true;
              }
            }, "Reveal My Offer")
          ])
        ]),
        // Animated sparkles overlay
        m(".absolute.inset-0.opacity-30.pointer-events-none", {
          style: {
            background: "radial-gradient(circle at 20% 50%, rgba(255,255,255,0.8) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(255,255,255,0.8) 0%, transparent 50%)",
            animation: "sparkle 4s ease-in-out infinite"
          }
        })
      ]),

      // Discount Notice Banner - Revealed Offer (Only for Lite version - ig_plan = 0)
      this.showRevealedOffer && this.showDiscountNotice && igPlan === 0 && m(".relative.overflow-hidden.mb-8.rounded-lg.max-w-6xl.mx-auto.px-12.mt-4.shadow-xl" + (this.isClosingNotice ? ".animate-fadeOut" : ".animate-slideDown"), {
        style: {
          background: "linear-gradient(135deg, #4f46e5 0%, #7c3aed 33%, #a855f7 66%, #c026d3 100%)"
        }
      }, [        // Close button
        m("button.absolute.text-white.text-3xl.font-bold.w-10.h-10.flex.items-center.justify-center.rounded-full.focus:outline-none", {
          type: "button",
          style: { top: "0.5rem", right: "0.5rem" },
          onclick: function(e) {
            e.stopPropagation();
            Gallery.dismissDiscountNotice();
          },
          title: "Close"
        }, "×"),        
        m(".relative.z-10.py-6", [
          // Flex container: image left, text middle, button right
          m(".flex.items-center.justify-between.gap-6", [
            // Left side: emoji image
            m("img.gentle-bounce", { 
              src: _wpThemeSettings && _wpThemeSettings.settings && _wpThemeSettings.settings.ig_img_path + "reveal_offer_emoji.png",
              alt: "Special Offer",
              style: { 
                width: "60px",
                height: "60px",
                border: "0",
                flexShrink: "0"
              }
            }),
            // Middle: heading and subtext
            m(".flex.flex-col.gap-2.text-left.flex-1", [
              m("h3.text-white.text-xl.md:text-2xl.font-black.leading-tight.drop-shadow-lg", [
                "Your exclusive discount is ready. You got ",
                m("span.text-white-300.text-2xl.md:text-3xl", "70% OFF"),
                " on MAX plan"
              ]),
              m("p.text-white.text-base.md:text-lg.font-medium.opacity-90", [
                "Get all premium features at a price lower than PRO—limited-time unlock"
              ])
            ]),
            // Right side: button
            m("button.bg-white.text-purple-600.font-bold.text-lg.py-4.px-10.rounded-full.shadow-2xl.hover:shadow-yellow-500/50.transform.hover:scale-110.transition-all.duration-300.focus:outline-none.whitespace-nowrap", {
              type: "button",
              style: { animationDuration: "2s" },
              onclick: function() {
                // Fire AJAX to track unlock action
                if (_wpThemeSettings && _wpThemeSettings.settings && _wpThemeSettings.settings.ajax_url) {
                  var xhr = new XMLHttpRequest();
                  xhr.open('POST', _wpThemeSettings.settings.ajax_url, true);
                  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                  
                  var params = 'action=ig_unlock_discount_notice&security=' + 
                               encodeURIComponent(_wpThemeSettings.settings.unlock_discount_nonce);
                  xhr.send(params);
                }
                
                // Open the purchase URL
                window.open("https://www.icegram.com/?buy-now=16542&qty=1&coupon=ig-eg-max-70&with-cart=1&utm_source=in-app&utm_medium=banner&utm_id=engage-max-discount", "_blank");
              }
            }, "Unlock MAX for $69")
          ])
        ]),
        // Animated sparkles overlay - more intense
        m(".absolute.inset-0.opacity-40.pointer-events-none", {
          style: {
            background: "radial-gradient(circle at 20% 50%, rgba(255,255,255,0.9) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(255,255,255,0.9) 0%, transparent 50%), radial-gradient(circle at 50% 20%, rgba(255,255,255,0.7) 0%, transparent 40%)",
            animation: "sparkle 3s ease-in-out infinite"
          }
        })
      ]),
      
      this.error &&
        m(".bg-red-100.border-l-4.border-red-500.text-red-700.p-4.mb-4", [
          m("p", this.error),
          m(
            "button.mt-2.bg-red-500.text-white.px-3.py-1.rounded.focus:outline-none",
            { onclick: function() { Gallery.loadProjects(); } },
            "Retry"
          )
        ]),

      // Shared container
      m(".max-w-6xl.mx-auto.px-4", [
        m("a", {
            href: "https://www.icegram.com/docs/category/icegram-engage/customize-gallery-templates/?utm_source=ig_gallery&utm_medium=ig_inapp_promo&utm_campaign=ig_custom_css",
            target: "_blank"
          },
          m("button.font-sans.font-bold.text-2xl.w-8.h-8.text-black.fixed.z-50.bg-gray-200.rounded-full.shadow-md.hover:bg-gray-300.transition.focus:outline-none", { 
            title: "Need help?",
            style: { top: "3rem", right: "1rem" }
          }, "?"),
        ),

        m("h3.text-xl.font-medium.font-black.mb-6", "Select a ready-made message template to save time. Start by selecting a template that fits your goal."),

        // Search bar
        m(".mb-6.flex.items-center.gap-4", [
          // Search Input
          m("input.flex-1.py-2.px-4.text-lg.border-2.border-gray-300.rounded-lg.focus:outline-none.focus:border-blue-500", {
            type: "text",
            placeholder: "Search templates...",
            value: this.searchQuery,
            oninput: function(e) { Gallery.handleSearch(e); }
          }),

          // Show All Button
          m("button.bg-indigo-600.hover:bg-indigo-500.text-white.text-sm.font-semibold.py-2.px-2.rounded.focus:outline-none", { 
            type: "button",
            onclick: function() {
              Gallery.showAllCategories();
              m.redraw();
            }
          }, "Show All")
        ]),

        // Categories
        this.showCategoryFilter
          ? (this.allProjectsLoaded
            ? m(".grid.grid-cols-1.sm:grid-cols-2.gap-8.mb-10", [
            this.categories.map(function(category) {

              var count = 0;
              console.log("Rendering category:", category.name, "allProjects length:", Gallery.allProjects.length);
              
              if (Gallery.allProjects && Gallery.allProjects.length > 0) {
                count = Gallery.allProjects.filter(function(project) {
                  if (!Array.isArray(project.custom_category)) {
                    return parseInt(project.custom_category) === parseInt(category.id);
                  }
                  return project.custom_category.some(function(catId) {
                    return parseInt(catId) === parseInt(category.id);
                  });
                }).length;
                console.log("  -> Category", category.name, "has", count, "items");
              } else {
                console.log("  -> allProjects not loaded yet or empty");
              }

              var hasImage = !!(category.feature_image && category.feature_image.guid);

              return m(".relative.rounded-xl.shadow-md.overflow-hidden.cursor-pointer.group", {
                onclick: function() { Gallery.handleFilterChange(category.id); },
                class: Gallery.currentFilter === category.id
                  ? "border-2 border-blue-500"
                  : "border border-gray-200",
                style: {
                  height: "350px"
                }
              }, [

                // Background wrapper (image or gradient)
                m("div.absolute.inset-0.overflow-hidden.flex.items-center.justify-center", [
                  m("div.w-full.h-full.group-hover:scale-110.category-bg-zoom", {
                    style: hasImage
                      ? {
                          backgroundImage: "url(" + category.feature_image.guid + ")",
                          backgroundSize: "cover",
                        }
                      : {
                          background: "linear-gradient(to right, #f5f5f5, #e5e5e5)",
                        }
                  }),

                  // If no image: show category name in middle
                  !hasImage && m("div.absolute.inset-0.flex.items-center.justify-center.pointer-events-none", [
                    m("span.text-gray-700.font-semibold.text-xl", category.name)
                  ])
                ]),

                // Smooth gradient overlay (same effect as your screenshot)
                m("div.absolute.inset-0.opacity-0.group-hover:opacity-100.transition-opacity.pointer-events-none", {
                  style: {
                    background: "linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0.2) 40%, rgba(0,0,0,0.5) 70%, rgba(0,0,0,0.8) 100%)",
                    transitionDuration: "500ms"
                  }
                }),

                // Center button
                m("div.absolute.inset-0.flex.items-center.justify-center.opacity-0.group-hover:opacity-100.transition-all", {
                  style: { transitionDuration: "500ms" }
                }, [
                  m("button.bg-white.text-indigo-600.font-semibold.py-2.px-5.rounded.shadow-md.hover:shadow-lg.transition.flex.items-center.gap-2.focus:outline-none",
                    {
                      type: "button"
                    },
                    [
                      "See templates",
                      m("span", "➜")
                    ]
                  )
                ]),

                // Items count badge - Always visible for debugging
                // m("div.absolute.text-xs.font-semibold.px-3.py-1.rounded-full.bg-white.border.shadow-md",{
                //   style: { top: "0.75rem", right: "0.75rem", backgroundColor: "rgba(255,255,255,0.9)" }
                // },
                //   count + " items"
                // )
              ]);
            })
          ])
            : m(".flex.justify-center.py-8", m(".animate-spin.rounded-full.h-12.w-12.border-t-2.border-b-2.border-blue-500"))
          )

          : m(".mb-6.flex.justify-between", [
              // Dynamic heading based on filter/search
              m("div", [
                m("h3.text-2xl.font-medium.text-black-800.mt-2", 
                  this.searchQuery.trim()
                    ? "Search results"
                    : (this.selectedCategory && this.selectedCategory.name
                        ? this.selectedCategory.name
                        : "")
                ),
                (!this.searchQuery.trim() && this.selectedCategory && this.selectedCategory.description)
                  ? m("p", this.selectedCategory.description)
                  : null
              ]),

              // Back link
              m("button.text-gray-500.hover:text-gray-400.text-sm.font-medium.flex.items-center.gap-1.focus:outline-none.focus:outline-none", {
                type: "button",
                onclick: function() { Gallery.showAllCategories(); }
              }, "Back to all categories" ),
            ]),

        // Project Grid
        this.hasInteracted && this.isLoading
          ? m(".flex.justify-center.py-8", m(".animate-spin.rounded-full.h-12.w-12.border-t-2.border-b-2.border-blue-500"))
          : this.hasInteracted && this.filteredProjects.length > 0 &&
              m(".grid.grid-cols-1.sm:grid-cols-2.md:grid-cols-3.lg:grid-cols-3.gap-6", 
                this.filteredProjects.map(function(project, index) {
                  var isLastItem = index === Gallery.filteredProjects.length - 1;
                  return m(ProjectCard, {
                    key: project.id,
                    project: project,
                    index: index,
                    isLast: isLastItem,
                    registerLast: function(el) { Gallery.lastProjectRef = el; },
                    onShowOverlay: function(img, desc, slug) {
                      Gallery.currentImage = img;
                      Gallery.currentDesc = desc;
                      Gallery.currentSlug = slug;
                      Gallery.currentId = project.campaign_id;
                      Gallery.currentPlan = project.plan;
                      Gallery.igPlan = parseInt((_wpThemeSettings && _wpThemeSettings.settings && _wpThemeSettings.settings.ig_plan) || "0");
                      Gallery.showOverlay = true;
                    }
                  });
                })
              ),

        // Loading more spinner
        this.isLoading && this.currentPage > 1 &&
          m(".flex.justify-center.my-8", 
            m(".animate-spin.rounded-full.h-8.w-8.border-t-2.border-b-2.border-blue-500")
          ),

        // No results message
        this.hasInteracted && !this.isLoading && this.filteredProjects.length === 0 &&
          m(".text-center.py-12.text-gray-500", "No projects found matching your criteria."),

        // End of results message
        !this.isLoading && this.filteredProjects.length > 0 &&
        this.currentPage * this.itemsPerPage >= this.totalItems &&
          m(".text-center.py-6.text-gray-500", "You've reached the end of results.")
      ]),

      this.showOverlay &&
        m(".fixed.inset-0.bg-black.bg-opacity-90.flex.flex-col", { style: { zIndex: 99999 } }, [

          // Browser mockup container (fullscreen)
          m(".bg-white.w-full.h-full.flex.flex-col.rounded-none.shadow-none", [

            // Simulated browser header
            m(".flex.items-center.justify-between.bg-gray-100.px-4.py-2.border-b", [

              // Left: traffic lights
              m(".flex.space-x-2", [
                m(".w-3.h-3.bg-red-500.rounded-full"),
                m(".w-3.h-3.bg-yellow-400.rounded-full"),
                m(".w-3.h-3.bg-green-500.rounded-full")
              ]),

              // Center: fake address bar
              m("div.flex-1.mx-96", [
                m("input.w-full.text-sm.px-3.py-1.rounded-md.bg-white.border.border-gray-300.text-gray-600.text-center.pointer-events-none", {
                  value: "https://www.icegram.com/gallery/galleryitem/" + this.currentSlug,
                  readonly: true
                })
              ]),

              this.igPlan >= this.currentPlan
              ? m("a", {
                  href: "?action=fetch_messages&campaign_id=" + this.currentId + "&gallery_item=" + this.currentSlug
                }, [
                  m("button.bg-indigo-600.hover:bg-indigo-500.text-white.text-sm.font-semibold.py-2.px-2.mr-4.rounded.focus:outline-none", {type: "button"}, "Use This")
                ])
              : m("a", {
                  href: "https://www.icegram.com/pricing/?utm_source=ig_inapp&utm_medium=ig_gallery&utm_campaign=get_" + (this.currentPlan === "3" ? "max" : "pro"),
                  target: "_blank"
                }, [
                  m("button.hover:bg-white-500.text-white.text-sm.font-semibold.py-2.px-2.mr-4.rounded.focus:outline-none", {
                    style: { backgroundColor: "hsl(169, 79%, 40%)" }
                  }, "Get The " + (this.currentPlan === "3" ? "Max" : "Pro") + " Plan")
                ]),

              

              // Right: close button styled like menu
              m("button.text-gray-600.hover:text-black.text-xl.font-bold.focus:outline-none", {
                title: "Close",
                type: "button",
                onclick: function() {
                  Gallery.showOverlay = false;
                  Gallery.currentImage = "";
                  Gallery.currentDesc = "";
                  Gallery.currentSlug = "";
                }
              }, "×")
            ]),

            // Iframe Preview
            m("div.flex-1.overflow-hidden", [
              m("iframe.w-full.h-full", {
                src: "https://www.icegram.com/gallery/galleryitem/" + this.currentSlug,
                allowfullscreen: true,
                frameborder: 0,
                class: "bg-white"
              })
            ]),
          ])
        ])
    ]);
  },
};

var ProjectCard = {
  oncreate: function(vnode) {
    var el = vnode.dom;
    el.classList.add("opacity-0", "translate-y-5"); // start hidden

    var observer = new IntersectionObserver(function(entries) {
      var entry = entries[0];
      if (entry.isIntersecting) {
        el.classList.remove("opacity-0", "translate-y-5");
        el.classList.add("fade-in-up");
        observer.disconnect(); // Only run once
      }
    }, {
      threshold: 0.1
    });

    observer.observe(el);

    // Register for last project lazy loading
    if (vnode.attrs.isLast && vnode.attrs.registerLast) {
      vnode.attrs.registerLast(el);
    }
  },
  view: function(vnode) {
    var project = vnode.attrs.project;
    var index = vnode.attrs.index;
    var isLast = vnode.attrs.isLast;
    var registerLast = vnode.attrs.registerLast;
    var onShowOverlay = vnode.attrs.onShowOverlay;

    var lastAttrs = isLast ? { oncreate: function(vnode) { registerLast(vnode.dom); } } : {};
    var attrs = Object.assign({ 
      key: project.id,
      onclick: function() {
        onShowOverlay((project.image && project.image.guid) || "", (project.title && project.title.rendered) || "Untitled", project.slug);
      }
    }, lastAttrs);

    return m(".relative.group.overflow-hidden.rounded-lg.shadow-md.hover:shadow-lg.transition-shadow.animate-fade-in-up.cursor-pointer", attrs, [
      m("img.w-full.object-cover.transform.group-hover:scale-105.transition-transform.border-0", { 
        src: (project.image && project.image.guid) || "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 3'%3E%3C/svg%3E",
        alt: (project.title && project.title.rendered) || "Project",
        style: { minHeight: "16rem", transitionDuration: "300ms" }
      }),
      m(".p-4", [
        m("h3.font-medium.text-lg.flex.items-center.justify-between.gap-2",[ 
          decodeHTML((project.title && project.title.rendered) || "Untitled"),
          
          // Plan label based on value
          project.plan === "3"
            ? m("span.text-xs.bg-purple-100.text-purple-800.font-semibold.px-2.py-1.rounded", "Max")
            : project.plan === "2"
              ? m("span.text-xs.bg-blue-100.text-blue-800.font-semibold.px-2.py-1.rounded", "Pro")
              : null // You can change to Free or Basic if needed
        ]),
      ])
    ]);
  }
};

function decodeHTML(html) {
  var txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}


// Add Nunito font and basic styles
document.head.insertAdjacentHTML("beforeend", "<link href='https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800&display=swap' rel='stylesheet'>" +
  "<style>" +
    ".post-type-ig_campaign #wpcontent {" +
        "background-color: white;" +
        "padding-left: 0;" +
    "}" +
    ".ig_campaign_page_icegram-gallery #wpcontent {" +
        "background-color: white;" +
        "padding-left: 0;" +
    "}" +
    ".ig_campaign_page_icegram-gallery #wpbody-content {" +
        "padding-bottom: 0;" +
    "}" +
    "[data-src] {" +
      "background: #f5f5f5;" +
      "min-height: 225px;" +
    "}" +
    "/* Category background zoom effect */" +
    ".category-bg-zoom {" +
      "transform: scale(1);" +
      "transition: transform 700ms ease-out;" +
    "}" +
    ".group:hover .category-bg-zoom {" +
      "transform: scale(1.1);" +
    "}" +
    "/* Fix for group-hover overlay on project cards */" +
    ".project-overlay {" +
      "background-color: rgba(0, 0, 0, 0);" +
      "transition: all 300ms;" +
    "}" +
    ".group:hover .project-overlay {" +
      "background-color: rgba(0, 0, 0, 0.3);" +
    "}" +
    "/* Additional helper class for fade-in animation */" +
    ".fade-in-up {" +
      "animation: fadeInUp 0.4s ease-out forwards !important;" +
    "}" +
    "/* Gradient animation for discount banner */" +
    "@keyframes gradientMove {" +
      "0% { background-position: 0% 50%; }" +
      "50% { background-position: 100% 50%; }" +
      "100% { background-position: 0% 50%; }" +
    "}" +
    "/* Sparkle animation */" +
    "@keyframes sparkle {" +
      "0%, 100% { opacity: 0.2; transform: scale(1); }" +
      "50% { opacity: 0.5; transform: scale(1.1); }" +
    "}" +
    "/* Slide down animation for banner */" +
    "@keyframes slideDown {" +
      "0% { opacity: 0; transform: translateY(-20px); }" +
      "100% { opacity: 1; transform: translateY(0); }" +
    "}" +
    ".animate-slideDown {" +
      "animation: slideDown 0.5s ease-out forwards;" +
    "}" +
    "/* Fade out animation for closing banner */" +
    "@keyframes fadeOut {" +
      "0% { opacity: 1; transform: scale(1); }" +
      "100% { opacity: 0; transform: scale(0.95); }" +
    "}" +
    ".animate-fadeOut {" +
      "animation: fadeOut 0.4s ease-in forwards;" +
    "}" +
    "/* Gentle bounce animation for emoji */" +
    "@keyframes gentleBounce {" +
      "0%, 100% { transform: translateY(0); }" +
      "50% { transform: translateY(-10px); }" +
    "}" +
    ".gentle-bounce {" +
      "animation: gentleBounce 2s ease-in-out infinite;" +
    "}" +
  "</style>"
);

// Lazy load images when they become visible
document.addEventListener("DOMContentLoaded", function() {
    var root = document.getElementById("ig-gallery-root");
    if (!root) return;
    var lazyImageObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
        if (entry.isIntersecting) {
            var lazyImage = entry.target;
            if (lazyImage.dataset.src) {
            lazyImage.src = lazyImage.dataset.src;
            lazyImage.removeAttribute("data-src");
            }
            lazyImageObserver.unobserve(lazyImage);
        }
        });
    });

  document.querySelectorAll("img[data-src]").forEach(function(img) {
    lazyImageObserver.observe(img);
  });
  
  // Mount the component
  m.mount(root, Gallery);
});