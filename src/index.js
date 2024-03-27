import { registerBlockVariation } from "@wordpress/blocks";

// Register a paragraph that displays the ISBN of a book.
registerBlockVariation("core/paragraph", {
	name: "book-isbn",
	title: "ISBN",
	icon: "book-alt",
	attributes: {
		metadata: {
			bindings: {
				content: { source: "core/post-meta", args: { key: "isbn" } },
			},
		},
	},
});

// Register a button that links to the Amazon page of a book.
registerBlockVariation("core/button", {
	name: "book-amazon",
	title: "Amazon",
	icon: "book-alt",
	attributes: {
		metadata: {
			bindings: {
				url: { source: "core/post-meta", args: { key: "amazon" } },
			},
		},
		text: "Amazon",
	},
});

// Register a button that links to the Goodreads page of a book.
registerBlockVariation("core/button", {
	name: "book-goodreads",
	title: "Goodreads",
	icon: "book-alt",
	attributes: {
		metadata: {
			bindings: {
				url: { source: "core/post-meta", args: { key: "goodreads" } },
			},
		},
		text: "Goodreads",
	},
});

// Register a block variation that displays the ISBN and buttons for a book.
registerBlockVariation("core/buttons", {
	name: "book-buttons",
	title: "Book Buttons",
	icon: "book-alt",
	innerBlocks: [
		[
			"core/button",
			{
				metadata: {
					bindings: {
						url: { source: "core/post-meta", args: { key: "amazon" } },
					},
				},
				text: "Amazon",
			},
		],
		[
			"core/button",
			{
				metadata: {
					bindings: {
						url: { source: "core/post-meta", args: { key: "goodreads" } },
					},
				},
				text: "Goodreads",
			},
		],
	],
});
