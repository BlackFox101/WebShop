const wrapperStyles = {
  display: 'flex',
  alignItems: 'center',
  justifyContent: 'center',
  height: '100vh',
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