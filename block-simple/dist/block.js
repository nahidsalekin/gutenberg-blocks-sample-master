(() => {
  // block.js
  var { registerBlockType } = wp.blocks;
  var { __ } = wp.i18n;
  registerBlockType(
    "gutenberg-blocks-sample/block-simple",
    {
      title: __("GB Sample - Simple Red Title"),
      icon: "universal-access-alt",
      category: "common",
      edit({ className }) {
        return /* @__PURE__ */ React.createElement("p", {
          className
        }, "This custom block will create a red title");
      },
      save() {
        const demo = () => {
          return 100;
        };
        return /* @__PURE__ */ React.createElement("h1", null, "The custom red title ", demo(), " :) ");
      }
    }
  );
})();
