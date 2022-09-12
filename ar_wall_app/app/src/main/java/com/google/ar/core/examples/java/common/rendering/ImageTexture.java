package com.google.ar.core.examples.java.common.rendering;

import android.opengl.GLES30;
import android.util.Log;

import com.google.ar.core.examples.java.common.samplerender.GLError;
import com.google.ar.core.examples.java.common.samplerender.SampleRender;
import com.google.ar.core.examples.java.common.samplerender.Texture;

import java.io.IOException;
import java.nio.ByteBuffer;


public class ImageTexture implements ITexture {
    private int[] handle = new int[1];

    private int width;
    private int height;

    private final int target = GLES30.GL_TEXTURE_2D;
    private final int colorFormat = GLES30.GL_RGBA;
    private final int byteFormat = GLES30.GL_UNSIGNED_BYTE;
    private final int minMagFilter = GLES30.GL_LINEAR;
    private final int wrapMode = GLES30.GL_REPEAT;

    public static ImageTexture createFromAsset(SampleRender render, String asset) throws IOException {
        ImageBuffer image = ImageBuffer.fromBitmap(render, asset);
        ImageTexture texture = new ImageTexture(image.getWidth(), image.getHeight());
        texture.setData(image.getWidth(), image.getHeight(), image.getBuffer());
        return texture;
    }

    public ImageTexture(int width, int height) {
        this.width = width;
        this.height = height;

        GLES30.glGenTextures(1, handle, 0);

        bind();

        // Generate an empty texture.
        GLES30.glTexImage2D(
                target,
                0,
                colorFormat,
                width,
                height,
                0,
                colorFormat,
                byteFormat,
                null);
        GLError.maybeThrowGLException("Failed to generate empty texture", "glTexImage2D");

        // Setup texture parameters.
        GLES30.glTexParameteri(target, GLES30.GL_TEXTURE_MIN_FILTER, minMagFilter);
        GLError.maybeThrowGLException("Failed to set texture parameter", "glTexParameteri");
        GLES30.glTexParameteri(target, GLES30.GL_TEXTURE_MAG_FILTER, minMagFilter);
        GLError.maybeThrowGLException("Failed to set texture parameter", "glTexParameteri");

        GLES30.glTexParameteri(target, GLES30.GL_TEXTURE_WRAP_S, wrapMode);
        GLError.maybeThrowGLException("Failed to set texture parameter", "glTexParameteri");
        GLES30.glTexParameteri(target, GLES30.GL_TEXTURE_WRAP_T, wrapMode);
        GLError.maybeThrowGLException("Failed to set texture parameter", "glTexParameteri");
        GLES30.glGenerateMipmap(target);
        GLError.maybeThrowGLException("Failed to generate mipmaps", "glGenerateMipmap");

    }

    @Override
    public int getTextureId() {
        return handle[0];
    }

    @Override
    public void bind() {
        GLES30.glBindTexture(target, getTextureId());
        GLError.maybeThrowGLException("Failed to bind texture", "glBindTexture");
    }

    public void setData(int width, int height, ByteBuffer data) {
        bind();
        GLES30.glTexSubImage2D(
                target,
                0,
                0,
                0,
                width,
                height,
                colorFormat,
                byteFormat,
                data
        );
        GLError.maybeThrowGLException("Failed to set data in texture.", "glTexSubImage2D");
    }

    @Override
    public void close() {
        if (getTextureId() != 0) {
            GLES30.glDeleteTextures(1, handle, 0);
            GLError.maybeLogGLError(Log.WARN, Texture.class.getSimpleName(), "Failed to free texture", "glDeleteTextures");
            handle[0] = 0;
        }
    }
}
