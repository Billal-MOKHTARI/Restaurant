import { createTheme} from '@mui/material/styles';

export const themeOptions =  createTheme( {

    palette: {
      type: 'dark',
      primary: {
        main: '#c53a3d',
      },
      secondary: {
        main: '#f50057',
      },
      mode: 'dark',
    },
    shape: {
      borderRadius: 30,
    },
    spacing: 8,
    props: {
      MuiButton: {
        size: 'large',
      },
      MuiButtonGroup: {
        size: 'large',
      },
      MuiCheckbox: {
        size: 'medium',
      },
      MuiFab: {
        size: 'large',
      },
      MuiFormControl: {
        margin: 'dense',
        size: 'medium',
      },
      MuiFormHelperText: {
        margin: 'dense',
      },
      MuiIconButton: {
        size: 'medium',
      },
      MuiInputBase: {
        margin: 'dense',
      },
      MuiInputLabel: {
        margin: 'dense',
      },
      MuiRadio: {
        size: 'medium',
      },
      MuiSwitch: {
        size: 'medium',
      },
      MuiTextField: {
        margin: 'dense',
        size: 'medium',
      },
    },
  });

  export default themeOptions;