var u=Object.defineProperty;var i=Object.getOwnPropertySymbols;var c=Object.prototype.hasOwnProperty,p=Object.prototype.propertyIsEnumerable;var r=(e,t,s)=>t in e?u(e,t,{enumerable:!0,configurable:!0,writable:!0,value:s}):e[t]=s,o=(e,t)=>{for(var s in t||(t={}))c.call(t,s)&&r(e,s,t[s]);if(i)for(var s of i(t))p.call(t,s)&&r(e,s,t[s]);return e};import{i as m,m as n}from"./vendor.7b0b1a93.js";import{g as d}from"./index.ee423bf3.js";const y={computed:o({},m(["currentPost","options","dynamicOptions"])),methods:{updateAioseo(){this.$set(this.$store.state,"currentPost",n(o({},this.$store.state.currentPost),o({},window.aioseo.currentPost)))}},mounted(){this.$nextTick(()=>{window.addEventListener("updateAioseo",this.updateAioseo)})},beforeDestroy(){window.removeEventListener("updateAioseo",this.updateAioseo)},async created(){const{options:e,dynamicOptions:t,currentPost:s,tags:a}=await d();this.$set(this.$store.state,"options",n(o({},this.$store.state.options),o({},e))),this.$set(this.$store.state,"dynamicOptions",n(o({},this.$store.state.dynamicOptions),o({},t))),this.$set(this.$store.state,"currentPost",n(o({},this.$store.state.currentPost),o({},s))),this.$set(this.$store.state,"tags",n(o({},this.$store.state.tags),o({},a)))}};export{y as S};
