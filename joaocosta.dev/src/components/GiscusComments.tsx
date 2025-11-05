'use client';

import Giscus from '@giscus/react';

export default function GiscusComments() {
  return (
    <Giscus
      id="comments"
      repo="JoaoCostaIFG/website"
      repoId="MDEwOlJlcG9zaXRvcnkyNjA5NzQyMjM="
      category="Announcements"
      categoryId="DIC_kwDOD44mj84Cxdzp"
      mapping="title"
      term="Welcome to @giscus/react component!"
      reactionsEnabled="1"
      emitMetadata="0"
      inputPosition="top"
      theme="noborder_gray"
      lang="en"
      loading="lazy"
    />
  );
}
