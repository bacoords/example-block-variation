import { registerPlugin } from "@wordpress/plugins";
import { PluginDocumentSettingPanel } from "@wordpress/editor";
import { PanelRow, TextControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import { useEntityProp } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";

const WPDevPageSettings = function () {
	// Get the current post type.
	const postType = useSelect((select) => {
		return select("core/editor").getCurrentPostType();
	});

	// If the post type is not "post", return null and disable the panel.
	if (postType !== "book") {
		return null;
	}

	// Get the current post meta.
	const [meta, setMeta] = useEntityProp("postType", "book", "meta");

	return (
		<PluginDocumentSettingPanel
			name="wpdev-post-settings"
			title={__("Book Settings")}
			className="wpdev-post-settings"
		>
			<PanelRow>
				<TextControl
					label={__("ISBN")}
					value={meta?.isbn}
					onChange={(value) => setMeta({ isbn: value })}
				/>
			</PanelRow>
			<PanelRow>
				<TextControl
					label={__("Amazon URL")}
					type="url"
					value={meta?.amazon}
					onChange={(value) => setMeta({ amazon: value })}
				/>
			</PanelRow>
			<PanelRow>
				<TextControl
					label={__("Goodreads URL")}
					type="url"
					value={meta?.goodreads}
					onChange={(value) => setMeta({ goodreads: value })}
				/>
			</PanelRow>
		</PluginDocumentSettingPanel>
	);
};

registerPlugin("wpdev-post-settings", { render: WPDevPageSettings });
