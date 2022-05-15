/**
* This file is a dummy file that doesn't do anything except
* does a fake registration of every bookwormgb block so that
* the WordPress plugin directory detects them and lists them
* in the bookwormgb plugin page.
*
* This file is auto-generated from the build process.
*/

registerBlockType( 'bwgb/accordion', {
	title: __( 'Accordion', i18n ),
	description: __( 'A title that your visitors can toggle to view more text. Use as FAQs or multiple ones for an Accordion.', i18n ),
	icon: AccordionIcon,
	category: 'layout',
	example: {
		attributes: {
			limit: 1,
			enableHeading: false,
			enableMaxwidth: false,
		}
	},
	keywords: [
		__( 'Accordion', i18n ),
		__( 'Toggle', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
	},
} )
registerBlockType( 'bwgb/author', {
	title: __( 'Authors', i18n ),
	description: __( 'Add an author biography.', i18n ),
	example: {
		attributes: {
			xlColumns: 3,
			enableCarousel: true,
		}
	},
	icon: AuthorIcon,
	category: 'layout',
	keywords: [
		__( 'Author', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.author.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/banner-with-product-carousel', {
	title: __( 'Banner with Product Carousel', i18n ),
	icon: ProductWihBannerIcon,
	category: 'layout',
	example: {
		attributes: {
			allowwAttributeDispatcher: false
		}
	},
	keywords: [
		__( 'Template', i18n ),
		__( 'BookwormGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	deprecated,
	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'bwgb/banner-with-products', {
	title: __( 'Banner with Products', i18n ),
	description: __( 'Banner with Products blocks.', i18n ),
	icon: ProductWihBannerIcon,
	category: 'layout',
	example: { },
	keywords: [
		__( 'Template', i18n ),
		__( 'BookwormGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,
} )
registerBlockType( 'bwgb/banners', {
	title: __( 'Banners', i18n ),
	icon: CTAIcon,
	category: 'layout',
	description: __( 'Start building your website with dozens of ready-to-use banners blocks.', i18n  ),
	example: {
		attributes: {
			limit: 1,
		}
	},
	keywords: [
		__( 'Banners', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},

		'custom-css': {
			default: applyFilters( 'bookwormgb.banners.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/blog-post', {
    title: __( 'Blog Posts', i18n ),
    description: __( 'Display a list of posts from your Blog.', i18n ),
    icon: BlogPostsIcon,
    example: {
        attributes: {
            postsToShow: 2,
            lgColumns: 2,
            hideEmptyComments: true,
        }
    },
    category: 'layout',
    keywords: [
        __( 'Blog Posts Block', i18n ),
        __( 'BookwormGB', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // BookwormGB modules.
    modules: {
        'advanced-responsive': true,
        'advanced-block-spacing': {
            height: false,
            width: false,
        },
        'custom-css': {
            default: applyFilters( 'bookwormgb.blog-post.custom-css.default', '' ),
        },
    },
} )
registerBlockType( 'bwgb/button', {
	title: __( 'Buttons', i18n ),
	description: __( 'Add a customizable buttons.', i18n ),
	icon: ButtonIcon,
	category: 'layout',
	example: {},
	keywords: [
		__( 'Buttons', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
            default: applyFilters( 'bookwormgb.button.custom-css.default', '' ),
        },
	},
} )
registerBlockType( 'bwgb/clients', {
	title: __( 'Clients', i18n ),
	description: __( 'Display a Social Network Icons.', i18n ),
	icon: ClientIcon,
	category: 'layout',
	example: {},
	keywords: [
		__( 'Clients', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.clients.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/columns', {
	title: __( 'Columns', i18n ),
	description: __( 'The columns block lets you create multi-column layouts within your content area, and include other blocks inside each column.', i18n ),
	icon: ColumnsIcon,
	example: {
		attributes: {
			allowwAttributeDispatcher: false
		},
		innerBlocks: [ { name: 'bwgb/column' } ],
	},
	category: 'layout',
	keywords: [
		__( 'Columns', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		'block-background': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.columns.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/coming-soon', {
	title: __( 'Coming Soon', i18n ),
	description: __( 'Coming Soon page displays a countdown timer when will be the page back.', i18n ),
	icon: ComingSoonIcon,
	category: 'layout',
	example: {},
	keywords: [
		__( 'Coming Soon', i18n ),
		__( 'Toggle', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.coming-soon.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/deal-product', {
	title: __( 'Deal Product', i18n ),
	description: __( 'Display on sale product view from your store.', i18n ),
	icon: ProductDealIcon,
	category: 'layout',
	keywords: [
		__( 'Deal Product', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	//BookwormGB modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.deal-product.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/footer', {
    title: __( 'Footer' ),
    description: __( 'A website footer is found at the bottom of your site pages. It typically includes important informations.' ),
    icon: BlogPostsIcon,
    example: {},
    category: 'layout',
    keywords: [
        __( 'Footer' ),
        __( 'bookwormGb' ),
    ],
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },
    attributes: schema,

    edit,
    save,

    // bookwormGB modules.
    // modules: {
    //     'advanced-responsive': true,
    // },
} )
registerBlockType( 'bwgb/gallery-carousel', {
    title: __( 'Gallery Carousel', i18n ),
    icon: GalleryIcon,
    category: 'layout',
    description: __( 'Display multiple images in gallery.', i18n  ),
    example: {},
    keywords: [
        __( 'Gallery Carousel', i18n ),
        __( 'BookwormGB', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // bookwormgb modules.
    modules: {
        'advanced-responsive': true,
        'advanced-block-spacing': {
            height: false,
            width: false,
        },
        'custom-css': {
            default: applyFilters( 'bookwormgb.gallery-carousel.custom-css.default', '' ),
        },
    },
} )
registerBlockType( 'bwgb/group', {
    title: __( 'Group', i18n ),
    description: __( 'A styled group that you can add other blocks inside. Use this to create unique layouts.', i18n ),
    icon: ContainerIcon,
    category: 'layout',
    example: {},
    keywords: [
        __( 'Group', i18n ),
        __( 'bookwormgb', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
        // Add EditorsKit block navigator toolbar.
        editorsKitBlockNavigator: true,
	},

    edit,
    save,

    // bookwormgb modules.
    modules: {
        'advanced-responsive': true,
        'advanced-block-spacing': {
            height: false,
            width: false,
        },
        'custom-css': {
            default: applyFilters( 'bookwormgb.group.custom-css.default', '' ),
        },
    },

    /**
     * For grouping & ungrouping blocks into Group blocks.
     * Based on the Group block.
     *
     */
    transforms: {
        from: [
            {
                type: 'block',
                isMultiBlock: true,
                blocks: [ '*' ],
                __experimentalConvert( blocks ) {
                    // Avoid transforming a single `bwgb/group` Block
                    if ( blocks.length === 1 && blocks[ 0 ].name === 'bwgb/group' ) {
                        return
                    }

                    // Clone the Blocks to be Grouped
                    // Failing to create new block references causes the original blocks
                    // to be replaced in the switchToBlockType call thereby meaning they
                    // are removed both from their original location and within the
                    // new group block.
                    const groupInnerBlocks = blocks.map( block => {
                        return createBlock( block.name, block.attributes, block.innerBlocks )
                    } )

                    return createBlock( 'bwgb/group', {}, groupInnerBlocks )
                },
            },

        ],
    },
} )
registerBlockType( 'bwgb/header', {
    title: __( 'Header' ),
    description: __( 'A large header title area. Typically used at the very top of a page.' ),
    icon: BlogPostsIcon,
    example: {},
    category: 'layout',
    keywords: [
        __( 'Header' ),
        __( 'bookwormGb' ),
    ],
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },
    attributes: schema,

    edit,
    save,

    // bookwormGB modules.
    // modules: {
    //     'advanced-responsive': true,
    // },
} )
registerBlockType( 'bwgb/hero-carousel-1', {
	title: __( 'Hero Carousel #1', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #1', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-1.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/hero-carousel-10', {
	title: __( 'Hero Carousel #10', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #10', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		// 'block-background': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-10.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/hero-carousel-2', {
	title: __( 'Hero Carousel #2', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #2', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		'block-background': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-2.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/hero-carousel-3', {
	title: __( 'Hero Carousel #3', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #3', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-3.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/hero-carousel-4', {
	title: __( 'Hero Carousel #4', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #4', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		'block-background': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-4.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/hero-carousel-5', {
	title: __( 'Hero Carousel #5', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #5', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		'block-background': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-5.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/hero-carousel-6', {
	title: __( 'Hero Carousel #6', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #6', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		// 'block-background': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-6.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/hero-carousel-7', {
	title: __( 'Hero Carousel #7', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #7', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		// 'block-background': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-7.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/hero-carousel-8', {
	title: __( 'Hero Carousel #8', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #8', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		'block-background': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-8.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/hero-carousel-9', {
	title: __( 'Hero Carousel #9', i18n ),
	description: __( 'A large hero area. Typically used at the very top of a page.', i18n ),
	example: { },
	icon: HeaderIcon,
	category: 'layout',
	keywords: [
		__( 'Hero Carousel #9', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'block-title': true,
		// 'block-background': true,
		'custom-css': {
			default: applyFilters( 'bookwormgb.hero-carousel-9.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/icon-blocks', {
	title: __( 'Icons', i18n ),
	icon: IconBlock,
	category: 'layout',
	description: __( 'Start building your website with dozens of ready-to-use icon blocks.', i18n  ),
	example: {
		attributes: {
			limit: 2,
		}
	},
	keywords: [
		__( 'Icons', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},

		'custom-css': {
            default: applyFilters( 'bookwormgb.icon-blocks.custom-css.default', '' ),
        },
	},
} )
registerBlockType( 'bwgb/megamenu', {
	title: __( 'Megamenu', i18n ),
	description: __( 'Megamenu is a large panel of content which is display a list of menu.', i18n ),
	icon: GridIcon,
	category: 'layout',
	example: {
		innerBlocks: [ { name: 'bwgb/columns' } ],
	},
	keywords: [
		__( 'Megamenu', i18n ),
		__( 'BookwormGB', i18n ),
	],
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,
} )
registerBlockType( 'bwgb/nav-menu', {
	title: __( 'Nav Menu', i18n ),
	description: __( 'Nav Menu allows you to display a nav menu with title.', i18n ),
	icon: MenuIcon,
	example: {},
	category: 'layout',
	keywords: [
		__( 'Nav Menu', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
            default: applyFilters( 'bookwormgb.nav-menu.custom-css.default', '' ),
        },
	},
} )
registerBlockType( 'bwgb/pricing-table', {
	title: __( 'Pricing Table', i18n ),
	icon: NumberBoxIcon,
	category: 'layout',
	description: __( 'Start building your website with dozens of ready-to-use featured blocks.', i18n  ),
	example: {
		attributes: {
			limit: 1,
			xlColumns: 1,
		}
	},
	keywords: [
		__( 'pricing-table', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'bwgb/product-categories', {
	title: __( 'Product Categories', i18n ),
	description: __( 'Add product categories block.', i18n ),
	icon: ProductCategoryIcon,
	example: {
		attributes: {
			limit: 4,
			wdColumns: 2,
			xlColumns: 2,
			lgColumns: 2,
		}
	},
	category: 'layout',
	keywords: [
		__( 'Product Categories', i18n ),
		__( 'BookworkmGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},

		'custom-css': {
			default: applyFilters( 'bookwormgb.product-categories.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/product-featured', {
	title: __( 'Product Featured', i18n ),
	description: __( 'Display featured products from your store.', i18n ),
	icon: ProductFeaturedIcon,
	example: {
		attributes: {}
	},
	category: 'layout',
	keywords: [
		__( 'Product Featured', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// BookwormGB modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.product-featured.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/product-video', {
	title: __( 'Product Video', i18n ),
	description: __( 'Display a product video in your website.', i18n ),
	icon: VideoPopupIcon,
	category: 'layout',
	example: {},
	keywords: [
		__( 'Product Video', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.product-video.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/products-banner', {
	title: __( 'Products Banner', i18n ),
	description: __( 'Banner to add with products', i18n ),
	icon: ProductBannerIcon,
	category: 'layout',
	example: {},
	keywords: [
		__( 'Products Banner', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.products-banner.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/products-carousel', {
	title: __( 'Products Carousel', i18n ),
	description: __( 'Display all products in carousel view from your store.', i18n ),
	icon: ProductCarouselIcon,
	example: {
		attributes: {
			wdColumns: 1,
			xlColumns: 1,
			limit: 1
		}
	},
	category: 'layout',
	keywords: [
		__( 'Products Carousel', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// BookwormGB modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.products-carousel.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/products-deals-carousel', {
	title: __( 'Products Deals Carousel', i18n ),
	description: __( 'Display on sale products in carousel view from your store.', i18n ),
	icon: ProductDealIcon,
	example: {
		attributes: {
			xlColumns: 1,
			limit: 1,
			enableBackground: false,
		}
	},
	category: 'layout',
	keywords: [
		__( 'Products Deals Carousel', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// BookwormGB modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.products-deals-carousel.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/products-grid-layouts', {
	title: __( 'Products Grid Layouts', i18n ),
	description: __( 'Display Produts in multiple grid view.', i18n ),
	icon: GridIcon,
	category: 'layout',
	example: { },
	keywords: [
		__( 'Products Grid Layouts', i18n ),
		__( 'BookwormGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,
} )
registerBlockType( 'bwgb/products-list', {
	title: __( 'Products List', i18n ),
	description: __( 'Display all products in list view from your store.', i18n ),
	icon: ProductListIcon,
	example: {
		attributes: {
			columns: 2,
			limit: 4
		}
	},
	category: 'layout',
	keywords: [
		__( 'Products List', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// BookwormGB modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.products-list.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/products-simple', {
	title: __( 'Products Simple', i18n ),
	description: __( 'Display all products from your store.', i18n ),
	icon: ProductSimpleIcon,
	example: {
		attributes: {
			columns: 2,
			limit: 4
		}
	},
	category: 'layout',
	keywords: [
		__( 'Products Simple', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// BookwormGB modules.
    modules: {
        'advanced-responsive': true,
        'advanced-block-spacing': {
            height: false,
            width: false,
        },
        'custom-css': {
            default: applyFilters( 'bookwormgb.products-simple.custom-css.default', '' ),
        },
    },
} )
registerBlockType( 'bwgb/products', {
	title: __( 'Products', i18n ),
	description: __( 'Display all products from your store.', i18n ),
	icon: ProductIcon,
	example: {
		attributes: {
			columns: 2,
			limit: 4
		}
	},
	category: 'layout',
	keywords: [
		__( 'Products', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},


	edit,
	save,

	// BookwormGB modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.products.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/sidebar-with-product-carousel', {
	title: __( 'Sidebar with product carousel', i18n ),
	icon: ProductWihBannerIcon,
	category: 'layout',
	example: {
		innerBlocks: [ { name: 'bwgb/products-list' } ],
	},
	keywords: [
		__( 'Template', i18n ),
		__( 'BookwormGB', i18n ),
	],
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'bwgb/single-author', {
	title: __( 'Single Author', i18n ),
	icon: SingleAuthorIcon,
	category: 'layout',
	description: __( 'Start building your website with dozens of ready-to-use featured blocks.', i18n  ),
	example: {},
	keywords: [
		__( 'single-author', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
	},
} )
registerBlockType( 'bwgb/single-product-carousel', {
	title: __( 'Single Product Carousel', i18n ),
	description: __( 'Display all products in carousel view from your store.', i18n ),
	icon: ProductCarouselIcon,
	example: {
		attributes: {
			limit: 1
		}
	},
	category: 'layout',
	keywords: [
		__( 'Single Product Carousel', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// BookwormGB modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.single-product-carousel.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/single-product-static', {
	title: __( 'Single Product Static ', i18n ),
	icon: NumberBoxIcon,
	category: 'layout',
	description: __( 'Display title with all products from your store.', i18n ),
	example: {
		innerBlocks: [ { name: 'bwgb/products' } ],
	},
	keywords: [
		__( 'Single Product Static', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.single-product-static.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/social-icon', {
	title: __( 'Social Network Icons', i18n ),
	description: __( 'Display a Social Network Icons.', i18n ),
	icon: SocialNetworkIcon,
	category: 'layout',
	example: {},
	keywords: [
		__( 'Social Network Icons', i18n ),
		__( 'bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.social-icon.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/stats-static', {
    title: __( 'Stats Static', i18n ),
    icon: IconListIcon,
    category: 'layout',
    description: __( 'Start building your website with dozens of ready-to-use Stats Static.', i18n  ),
    example: {},
    keywords: [
        __( 'stats-static', i18n ),
        __( 'BookwormGb', i18n ),
    ],
    attributes: schema,
    supports: {
        inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
    },

    edit,
    save,

    // bookwormgb modules.
    modules: {
        'advanced-responsive': true,
        'advanced-block-spacing': {
            height: false,
            width: false,
        },
        'custom-css': {
            default: applyFilters( 'bookwormgb.stats-blocks.custom-css.default', '' ),
        },
    },
} )
registerBlockType( 'bwgb/tabs', {
	title: __( 'Tabs', i18n ),
	description: __( 'A highly customizable tabs block with the ability to nest any Gutenberg block as the tab content.', i18n ),
	icon: TabsIcon,
	category: 'layout',
	example: {
		attributes: {
			allowwAttributeDispatcher: false
		},
		innerBlocks: [ { name: 'bwgb/tab-content' } ],
	},
	keywords: [
		__( 'Tabs', i18n ),
		__( 'BookwormGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
			default: applyFilters( 'bookwormgb.tabs.custom-css.default', '' ),
		},
	},
} )
registerBlockType( 'bwgb/team-member', {
	title: __( 'Team Member', i18n ),
	description: __( 'Display members of your team or your office. Use multiple Team Member blocks if you have a large team.', i18n ),
	example: {
		attributes: {
			xlColumns: 3,
			className: 'm-0'
		}
	},
	icon: TeamMemberIcon,
	category: 'layout',
	keywords: [
		__( 'Team Member', i18n ),
		__( 'BookwormGb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// bookwormgb modules.
	modules: {
		'advanced-responsive': true,
		'advanced-block-spacing': {
			height: false,
			width: false,
		},
		'custom-css': {
            default: applyFilters( 'bookwormgb.team-member.custom-css.default', '' ),
        },
	},
} )
registerBlockType( 'bwgb/template', {
	title: __( 'Template', i18n ),
	description: __( 'Template block has nested of multiple blocks.', i18n ),
	icon: LayoutIcon,
	category: 'layout',
	example: { },
	keywords: [
		__( 'Template', i18n ),
		__( 'BookwormGB', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,
} )
registerBlockType( 'bwgb/testimonial', {
	title: __( 'Testimonial', i18n ),
	description: __( 'Showcase what your users say about your product or service.', i18n ),
	icon: TestimonialIcon,
	example: { },
	category: 'layout',
	keywords: [
		__( 'Testimonial', i18n ),
		__( 'Bookwormgb', i18n ),
	],
	attributes: schema,
	supports: {
		inserter: ! disabledBlocks.includes( name ), // Hide if disabled.
	},

	edit,
	save,

	// BookwormGB modules.
    modules: {
        'advanced-responsive': true,
        'advanced-block-spacing': {
            height: false,
            width: false,
        },
        'custom-css': {
            default: applyFilters( 'bookwormgb.testimonial.custom-css.default', '' ),
        },
    },
} )