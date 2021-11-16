import './CardContainer.module.css';
import React from 'react'

/**
 * @param {{
 *   title: string,
 * }}
 */
function CardContainer({
    title,
    children
}) {
  return (
      <div className={cardContainer}>
        <div className={title}>{title}</div>
        {children}
      </div>
  )
}

export {
  CardContainer,
}
