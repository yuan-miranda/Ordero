(function replaceDollarSigns() {
    const treeWalker = document.createTreeWalker(
      document.body,
      NodeFilter.SHOW_TEXT,
      {
        acceptNode: function(node) {
          return node.nodeValue.includes('$') ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_SKIP;
        }
      }
    );
  
    const nodes = [];
    while (treeWalker.nextNode()) {
      nodes.push(treeWalker.currentNode);
    }
  
    for (const node of nodes) {
      node.nodeValue = node.nodeValue.replace(/\$/g, '₱');
    }
  })();
  