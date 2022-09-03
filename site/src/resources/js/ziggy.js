const Ziggy = {"url":"https:\/\/localhost","port":null,"defaults":{},"routes":{"api-user":{"uri":"api\/user","methods":["GET","HEAD"]},"api-img":{"uri":"api\/blog\/img","methods":["POST"]},"api-img_list":{"uri":"api\/blog\/imgs\/{id}","methods":["GET","HEAD"],"wheres":{"id":"[0-9]+"}},"api-img_delete":{"uri":"api\/blog\/img\/{id}\/{name}","methods":["DELETE"],"wheres":{"id":"[0-9]+"}}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
