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
      <div className={classes.cardContainer}>
        <div className={classes.title}>{title}</div>
        {children}
      </div>
  )
}

export {
  CardContainer,
}
