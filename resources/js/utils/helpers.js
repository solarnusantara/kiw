// const publicPath = "/public";
// const asset = (path = "") => publicPath + path;
const publicPath = "/public";
const asset = (path = "") => path;
const imagePlaceholder = (size = "square") =>
    size == "square"
        ? asset("/assets/img/placeholder.webp")
        : asset("/assets/img/placeholder-rect.webp");

export default {
    publicPath,
    asset,
    imagePlaceholder,
};
