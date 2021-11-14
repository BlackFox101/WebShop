import React from 'react';
const wrapperStyles = {
  display: 'flex',
  alignItems: 'center',
  justifyContent: 'center',
  height: 'calc(100vh - 50px)',
}

function withContentAreaInCenter(WrappedComponent) {
  return () => (
      <div style={wrapperStyles}>
        <WrappedComponent />
      </div>
  )
}

export {
  withContentAreaInCenter,
}