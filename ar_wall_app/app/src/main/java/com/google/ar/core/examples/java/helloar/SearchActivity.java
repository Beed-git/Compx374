package com.google.ar.core.examples.java.helloar;

import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.google.ar.core.examples.java.webapi.WebApiThread;

import org.w3c.dom.Text;


public class SearchActivity extends AppCompatActivity{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //System.out.println(("Hi Brad"));
        setContentView(R.layout.activity_search);

        try{

            //String[] imageNames = {"https://tuakiri.trex-sandwich.com/images/login-background.jpg", "https://tuakiri.trex-sandwich.com/images/example-mural.jpg"};
            String[] imageNames = {"https://image.shutterstock.com/image-illustration/huge-medieval-snake-glowing-green-600w-1638992110.jpg",
                     "https://www.belloflostsouls.net/wp-content/uploads/2021/12/icespire-header.jpg",
                    "https://image.shutterstock.com/image-illustration/red-dragon-blue-magic-swirling-260nw-1124418902.jpg",
                    "https://image.shutterstock.com/image-illustration/adventurer-came-across-golden-dragon-600w-1981678550.jpg",
                    "https://image.shutterstock.com/image-photo/dungeons-dragons-scene-made-miniatures-600w-1090759115.jpg"};//,
                    //"https://image.shutterstock.com/image-illustration/painting-red-dragon-flying-over-600w-1436845406.jpg"};

            String[] textViewNames = {"Dragon", "Dragaon + People", "Another Dragon", "Yet Another Dragon", "Too many Dragons"};// "Yup that's enough"};
//            ImageButton imageButton;
//            TextView textView;
//
//            //Getting layout that contains the two images we want to update.
//            LinearLayout container =  findViewById(R.id.first2images);
//            LinearLayout firstLayout = (LinearLayout) container.getChildAt(0);
//            LinearLayout secondLayout = (LinearLayout) container.getChildAt(1);
//
//            //Finding ids of images and textviews to update.
//            int[] imageButtonIds = {firstLayout.getChildAt(0).getId(), secondLayout.getChildAt(0).getId()};
//            int[] textViewIds = {firstLayout.getChildAt(1).getId(), secondLayout.getChildAt(1).getId()};
//
//            for(int i = 0; i<2; i++){
//                //Assigning images to each image button and updating its text view.
//                imageButton = findViewById(imageButtonIds[i]);
//                textView = findViewById(textViewIds[i]);
//                imageButton.setImageBitmap(WebApiThread.getInstance().getImageFromURL(imageNames[i]).get());
//                textView.setText(textViewNames[i]);
//            }

            //Generating all views for number of images found on server (hard coded for now).
            for(int i = 0; i< imageNames.length; i+=2){
                //Getting parent
                LinearLayout parent = findViewById(R.id.parent);
                //Creating linear layouts
                LinearLayout verticalLayout1 = createLinearLayout(true, 1);
                LinearLayout verticalLayout2 = createLinearLayout(true, 1);
                LinearLayout horizontalLayout = createLinearLayout(false, 1);

                //Adding horizontal view
                parent.addView(horizontalLayout);

                //Checking if there are an odd number of images.
                if(i+1 == imageNames.length){
                    ImageButton newImageButton1 = createImageButton(imageNames[i]);
                    TextView newTextView1 = createTextView(textViewNames[i]);
                    //Adding vertical views to horizontal views
                    horizontalLayout.addView(verticalLayout1);
                    horizontalLayout.addView(verticalLayout2);

                    //Adding Image View and Text view
                    verticalLayout1.addView(newImageButton1);
                    verticalLayout1.addView(newTextView1);
                }
                else
                {
                    ImageButton newImageButton1 = createImageButton(imageNames[i]);
                    ImageButton newImageButton2 = createImageButton(imageNames[i+1]);

                    TextView newTextView1 = createTextView(textViewNames[i]);
                    TextView newTextView2 = createTextView(textViewNames[i+1]);

                    //Adding vertical views to horizontal views
                    horizontalLayout.addView(verticalLayout1);
                    horizontalLayout.addView(verticalLayout2);

                    //Adding Image View and Text view
                    verticalLayout1.addView(newImageButton1);
                    verticalLayout1.addView(newTextView1);
                    verticalLayout2.addView(newImageButton2);
                    verticalLayout2.addView(newTextView2);
                }


            }
        }
        catch (Exception e)
        {
            e.printStackTrace();
        }
    }

    //Creating a Text View
    protected TextView createTextView(String text){
        TextView newTextView = new TextView(this);
        newTextView.setText(text);

        LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                LinearLayout.LayoutParams.MATCH_PARENT,
                LinearLayout.LayoutParams.WRAP_CONTENT);

        newTextView.setLayoutParams(params);
        return newTextView;
    }

    //Creating a linear layout
    protected LinearLayout createLinearLayout(boolean vertical, int weight){
        LinearLayout newLayout = new LinearLayout(this);
        //Adding params

        LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                LinearLayout.LayoutParams.MATCH_PARENT,
                LinearLayout.LayoutParams.MATCH_PARENT,
                1.0f);

        newLayout.setLayoutParams(params);

        //Checking if wanting a vertical layout
        if(vertical) {
            newLayout.setOrientation(LinearLayout.VERTICAL);
            newLayout.setPadding(10, 0, 10, 5);
        }
        else {
            newLayout.setOrientation(LinearLayout.HORIZONTAL);
        }
        return newLayout;
    }

    //Creates a new image button
    protected ImageButton createImageButton(String url){
        //Creating button
        ImageButton newImageButton = new ImageButton(this);
        try{
            //Adding params
            LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT);

            newImageButton.setLayoutParams(params);

            //Adding url
            newImageButton.setImageBitmap(WebApiThread.getInstance().getImageFromURL(url).get());
        }
        catch (Exception e){
            e.printStackTrace();
        }
        //Returning the imageButton
        return newImageButton;
    }


    //Fetch images from server "http...."
    //Assign an image to each imagebutton
    //onButtonClick get image id

}
