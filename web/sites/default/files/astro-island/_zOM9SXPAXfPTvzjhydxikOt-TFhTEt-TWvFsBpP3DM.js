// See https://project.pages.drupalcode.org/canvas/ for documentation on how to build a code component
import { jsx as _jsx, jsxs as _jsxs } from "react/jsx-runtime";
const Component = ({ list })=>{
    return /*#__PURE__*/ _jsxs("div", {
        className: "text-3xl",
        children: [
            "Developers & Publishers:",
            /*#__PURE__*/ _jsx("br", {}),
            list
        ]
    });
};
export default Component;
